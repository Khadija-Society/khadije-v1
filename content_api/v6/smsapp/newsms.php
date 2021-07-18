<?php
namespace content_api\v6\smsapp;


class newsms
{
	private static $update_insert             = 'insert';
	private static $sms_id                    = null;
	private static $need_archive_conversation = [];


	public static function set_archive_conversation()
	{
		if(empty(self::$need_archive_conversation))
		{
			return;
		}

		self::$need_archive_conversation = array_filter(self::$need_archive_conversation);
		self::$need_archive_conversation = array_unique(self::$need_archive_conversation);

		if(self::$need_archive_conversation)
		{
			\lib\db\conversation\update::multi_archive_conversation(self::$need_archive_conversation, \lib\app\platoon\tools::get_index_locked());
		}
	}

	public static function force_archive_conversation($_mobile)
	{
		\lib\db\conversation\update::archive_conversation($_mobile, \lib\app\platoon\tools::get_index_locked());
	}

	public static function lost($_args)
	{
		\dash\app::variable([]);
		\dash\app::variable($_args);

		$md5 = \dash\app::request('md5');
		if(!$md5)
		{
			$md5           = \dash\app::request('MD5');
		}

		if(!$md5)
		{
			\dash\notif::warn('md5 not set');
			return false;
		}
		if(mb_strlen($md5) !== 32)
		{
			\dash\notif::warn('Invalid md5 - len is not 32');
			return false;
		}

		$get = \lib\db\sms::get(['md5' => $md5, 'limit' => 1]);
		if(isset($get['id']))
		{
			return \dash\coding::encode($get['id']);
		}
		else
		{
			\dash\log::set('apiSmsLostNotFound', ['xdata' => json_encode($_args)]);
			return self::multi_add_new_sms($_args);
		}
	}

	public static function multi_add_new_sms($_args)
	{

		self::$update_insert = 'insert';
		self::$sms_id        = null;

		\dash\app::variable([]);
		\dash\app::variable($_args);

		// check from is not block or family
		$from        = \dash\app::request('from');
		if($from && mb_strlen($from) > 90)
		{
			\dash\notif::error(T_("Invalid from"));
			\dash\log::set('apiSmsAppInvalidFrom');
			return false;
		}

		$text = \dash\app::request('text');

		$date = \dash\app::request('date');

		$date = \dash\utility\convert::to_en_number($date);

		if($date && !strtotime($date))
		{
			\dash\notif::error(T_("Invalid date"));
			\dash\log::set('apiSmsAppInvalidDate');
			return false;
		}


		$from_mobile = \dash\utility\filter::mobile($from);
		$user_id     = null;

		// if from is mobile signup it
		if($from_mobile)
		{
			$from        = $from_mobile;
			$get_user_id = \dash\db\users::get_by_mobile($from_mobile);

			if(isset($get_user_id['id']))
			{
				$user_id = $get_user_id['id'];
			}
			else
			{
				$user_id = \dash\db\users::signup(['mobile' => $from_mobile]);
			}
		}

		if(!$from)
		{
			\dash\notif::error(T_("From number is required"));
			\dash\log::set('apiSmsAppFromIsNull');
			return false;
		}

		$brand         = \dash\app::request('brand');
		$md5           = \dash\app::request('md5');
		if(!$md5)
		{
			$md5           = \dash\app::request('MD5');
		}
		$model         = \dash\app::request('model');
		$simcartserial = \dash\app::request('simcart-serial');
		$smsmessageid  = \dash\app::request('smsMessage-id');
		$userdata      = \dash\app::request('userdata');


		$insert                  = [];
		$insert['brand']         = substr($brand, 0, 99);
		$insert['md5']           = substr($md5, 0, 32);
		$insert['model']         = substr($model, 0, 99);
		$insert['simcartserial'] = substr($simcartserial, 0, 99);
		$insert['smsmessageid']  = substr($smsmessageid, 0, 99);
		$insert['userdata']      = substr($userdata, 0, 99);
		$insert['fromnumber']    = $from;
		$insert['togateway']     = \dash\utility\filter::mobile(\dash\header::get('gateway'));
		$insert['fromgateway']   = null;
		$insert['tonumber']      = null;
		$insert['user_id']       = $user_id;
		$insert['datereceive']   = date("Y-m-d H:i:s");
		$insert['date']          = date("Y-m-d H:i:s", strtotime($date));
		$insert['text']          = $text;
		$insert['smscount']      = mb_strlen($text);
		$insert['uniquecode']    = null;
		$insert['receivestatus'] = 'awaiting';
		$insert['sendstatus']    = null;
		$insert['amount']        = null;
		$insert['answertext']    = null;
		$insert['group_id']      = null;
		$insert['recommend_id']  = null;
		$insert['platoon']    = \lib\app\platoon\tools::get_index_locked();

		self::ready_to_update_or_insert($insert);

		if(self::ad_number($insert))
		{
			self::$need_archive_conversation[] = $from;
			self::force_archive_conversation($from);

		}
		else
		{
			if(self::detect_5_min_message($insert))
			{
				//
			}
			else
			{
				self::check_need_analyze($insert);
			}
		}



		$id = self::add_update($insert);


		// if($insert['group_id'])
		// {
		// 	\lib\db\smsgroup::update_group_count($insert['group_id']);
		// }

		if($id)
		{
			return \dash\coding::encode($id);
		}

		return false;
	}



	private static function ad_number(&$insert)
	{
		$fromnumber = $insert['fromnumber'];

		if(!is_numeric($fromnumber))
		{
			$insert['receivestatus'] = 'block';
			return true;
		}

		if(in_array(substr($fromnumber, 0, 3), ['981', '982', '983', '985']))
		{
			$insert['receivestatus'] = 'block';
			return true;
		}

		if(in_array(substr($fromnumber, 0, 4), ['9898']))
		{
			$insert['receivestatus'] = 'block';
			return true;
		}

		if(!\dash\utility\filter::ir_mobile($fromnumber))
		{
			$insert['receivestatus'] = 'block';
			return true;
		}

		return false;
	}


	private static function ready_to_update_or_insert(&$insert)
	{
		$fromnumber   = $insert['fromnumber'];

		$get_last_sms = \lib\db\sms::get_last_sms($fromnumber, \lib\app\platoon\tools::get_index_locked());

		if(isset($get_last_sms['date']))
		{

			$date = $get_last_sms['date'];

			$id             = $get_last_sms['id'];
			$text           = $get_last_sms['text'];

			if($insert['text'] === $text)
			{
				// duplicate message
				// my son is send some request in one time
				// we check it to not save duplicate message :|
				\dash\log::set('apiSmsAppDuplicateNewMessage');
				self::$sms_id = intval($get_last_sms['id']);
				self::$update_insert = 'non';
				return;
			}

			if(abs(strtotime($insert['date']) - strtotime($date)) < 5)
			{

				self::$sms_id = intval($get_last_sms['id']);
				self::$update_insert = 'non';
				return;
			}
		}


	}


	private static function detect_5_min_message(&$insert)
	{
		$my_5_min = date("Y-m-d H:i:s", (time() - (60*5)));
		$get_last_sms_answered_in_5_min =  \lib\db\sms::get_count_answerd_in_time($insert['fromnumber'], $my_5_min, \lib\app\platoon\tools::get_index_locked());

		if(floatval($get_last_sms_answered_in_5_min) >= 1 )
		{

			self::$need_archive_conversation[] = $insert['fromnumber'];
			self::force_archive_conversation($insert['fromnumber']);

			$insert['answertext']      = null;
			$insert['answertextcount'] = 0;
			$insert['receivestatus']   = 'skip';
			$insert['group_id']        = null;
			return true;
		}

		return false;
	}


	private static function add_update($_insert)
	{
		if(self::$update_insert === 'update' && self::$sms_id)
		{
			unset($_insert['receivestatus']);
			unset($_insert['sendstatus']);

			\lib\db\sms::update($_insert, self::$sms_id);
			return intval(self::$sms_id);
		}
		elseif(self::$update_insert === 'insert')
		{
			$id = \lib\db\sms::insert($_insert);
			return $id;
		}
		elseif(self::$update_insert === 'non')
		{
			return intval(self::$sms_id);
		}
	}




	private static function check_need_analyze(&$insert)
	{
		$number       = $insert['fromnumber'];
		$mobileNumber = \dash\utility\filter::mobile($number);
		$number_no_plus = str_replace("+", '', $number);

		if($mobileNumber)
		{
			$get = \lib\db\smsgroupfilter::get(['type' => 'number', 'platoon' => \lib\app\platoon\tools::get_index_locked(), '1.1' => ["= 1.1", "AND (`number` = '$number' OR `number` = '$number_no_plus' OR `number` = '$mobileNumber')"], 'limit' => 1]);
		}
		else
		{
			$get = \lib\db\smsgroupfilter::get(['type' => 'number', 'platoon' => \lib\app\platoon\tools::get_index_locked(), '1.1' => [" = 1.1" , "AND ( `number` = '$number' OR `number` = '$number_no_plus') "], 'limit' => 1]);
		}

		// this number not found in any filter
		// FINDED ONE GROP BY NUMBER
		if(isset($get['group_id']))
		{
			$insert['group_id'] = $get['group_id'];

			$get_group = \lib\db\smsgroup::get(['id' => $get['group_id'], 'limit' => 1]);

			if(isset($get_group['status']) && $get_group['status'] === 'enable')
			{
				if(array_key_exists('analyze', $get_group) && !$get_group['analyze'])
				{
					self::$need_archive_conversation[] = $insert['fromnumber'];
					self::force_archive_conversation($insert['fromnumber']);

					$insert['receivestatus']  = 'block';
					// if the message is block not check recommend
					return;
				}
			}
		}

		$text          = $insert['text'];
		$get_recommend = \lib\app\sms::analyze_text($text, \lib\app\platoon\tools::get_index_locked());

		if(isset($get_recommend['id']))
		{
			$insert['recommend_id'] = $get_recommend['id'];
			$insert['fromgateway']  = $insert['togateway'];
			$insert['tonumber']     = $insert['fromnumber'];
			$insert['group_id']     = $insert['recommend_id'];
			$insert['dateanswer']   = date("Y-m-d H:i:s");

			$calcdate = a($get_recommend, 'calcdate');

			if(!$calcdate)
			{
				$calcdate = date("Y-m-d H:i:s", strtotime("-1 month"));
			}

			$get_count_answered =  \lib\db\sms::get_count_answerd_in_time($insert['fromnumber'], $calcdate, \lib\app\platoon\tools::get_index_locked());

			$need_answer_level = floatval($get_count_answered);

			$answer = null;
			// find answer
			$find_answer = \lib\db\smsgroupfilter::get(['type' => 'answer', 'group_id' => $get_recommend['id']], ['order' => ' ORDER BY s_groupfilter.sort ASC ']);

			if(isset($find_answer[$need_answer_level]['text']))
			{
				$answer = $find_answer[$need_answer_level]['text'];
			}
			else
			{
				$end_answer = end($find_answer);
				if(isset($end_answer['text']))
				{
					$answer = $end_answer['text'];
				}
			}


			if($answer)
			{
				if(strpos($answer, ':name:') !== false)
				{
					$user_displayname = \lib\db\conversation\search::get_one_user_displayname($insert['fromnumber']);

					$answer = str_replace(':name:', $user_displayname, $answer);
				}


				$insert['answertext']      = $answer;
				$insert['answertextcount'] = mb_strlen($answer);

				self::$need_archive_conversation[] = $insert['fromnumber'];
				self::force_archive_conversation($insert['fromnumber']);


				if(\lib\app\sms::is_auto_panel_answer())
				{
					$insert['sendstatus']    = 'awaiting';
					$insert['receivestatus'] = 'sendtopanel';
				}
				else
				{
					$insert['sendstatus']    = 'waitingtoautosend';
					$insert['receivestatus'] = 'answerready';
				}
			}


		}
	}


	private static function fixText($_text)
	{
		$_text = strip_tags($_text);
		$_text = str_replace('[', ' ', $_text);
		$_text = str_replace(']', ' ', $_text);
		$_text = str_replace('{', ' ', $_text);
		$_text = str_replace('}', ' ', $_text);
		$_text = str_replace('"', ' ', $_text);
		$_text = str_replace('؛', ' ', $_text);
		$_text = str_replace("'", ' ', $_text);
		$_text = str_replace('(', ' ', $_text);
		$_text = str_replace(')', ' ', $_text);
		$_text = str_replace(':', ' ', $_text);
		$_text = str_replace(',', ' ', $_text);
		$_text = str_replace('،', ' ', $_text);
		$_text = str_replace('-', ' ', $_text);
		$_text = str_replace('_', ' ', $_text);
		$_text = str_replace('?', ' ', $_text);
		$_text = str_replace('؟', ' ', $_text);
		$_text = str_replace('.', ' ', $_text);
		$_text = str_replace('=', ' ', $_text);
		$_text = str_replace('
', ' ', $_text);

		$_text = str_replace("\n", ' ', $_text);
		$_text = str_replace('!', ' ', $_text);
		$_text = str_replace('&nbsp;', ' ', $_text);
		return trim($_text);
	}
}
?>