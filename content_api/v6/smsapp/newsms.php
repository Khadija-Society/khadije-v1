<?php
namespace content_api\v6\smsapp;


class newsms
{

	public static function add_new_sms()
	{

		// check from is not block or family
		$from        = \dash\request::post('from');
		if($from && mb_strlen($from) > 90)
		{
			\dash\notif::error(T_("Invalid from"));
			\dash\log::set('apiSmsAppInvalidFrom');
			return false;
		}

		$text        = \dash\request::post('text');

		$date        = \dash\request::post('date');

		if($date && !strtotime($date))
		{
			\dash\notif::error(T_("Invalid date"));
			\dash\log::set('apiSmsAppInvalidDate');
			return false;
		}


		$from_mobile = \dash\utility\filter::mobile($from);
		$user_id     = null;

		if($from_mobile)
		{
			$from        = $from_mobile;
			$get_user_id = \dash\db\users::get_by_mobile($from_mobile);

			if(isset($get_user_id['id']))
			{
				$user_id = $get_user_id['id'];
			}
		}

		if(!$from)
		{
			\dash\notif::error(T_("From number is required"));
			\dash\log::set('apiSmsAppFromIsNull');
			return false;
		}

		$brand          = \dash\request::post('brand');
		$model          = \dash\request::post('model');
		$simcart_serial = \dash\request::post('simcart-serial');
		$smsMessage_id  = \dash\request::post('smsMessage-id');
		$userdata       = \dash\request::post('userdata');


		$insert               = [];
		$insert['fromnumber'] = $from;
		$insert['togateway']     = \dash\header::get('gateway');
		$insert['fromgateway']   = null;
		$insert['tonumber']      = null;
		$insert['user_id']       = $user_id;
		$insert['date']          = date("Y-m-d H:i:s", strtotime($date));
		$insert['text']          = $text;
		$insert['uniquecode']    = null;
		$insert['receivestatus'] = 'awaiting';
		$insert['sendstatus']    = null;
		$insert['amount']        = null;
		$insert['answertext']    = null;
		$insert['group_id']      = null;
		$insert['recommend_id']   = null;

		self::check_need_analyze($insert);

		$id = self::check_add_update($insert);


		if($insert['group_id'])
		{
			\lib\db\smsgroup::update_group_count($insert['group_id']);
		}

		if($id)
		{
			\dash\log::set('apiSmsAppNewSaved', ['code' => $id]);
			\dash\notif::ok(T_("Message saved"));
			return ['smsid' => \dash\coding::encode($id)];
		}

		\dash\log::set('apiSmsAppCanNotSave');
		return false;
	}


	private static function check_add_update($_insert)
	{
		$fromnumber = $_insert['fromnumber'];
		$get_last_sms = \lib\db\sms::get_last_sms($fromnumber);
		if(isset($get_last_sms['date']))
		{
			$date = $get_last_sms['date'];
			if(strtotime($_insert['date']) - strtotime($date) < 30)
			{
				$id             = $get_last_sms['id'];
				$text           = $get_last_sms['text'];
				$new_text       = $text. ' '. $_insert['text'];

				$update         = [];
				$update['text'] = $new_text;

				if(!$get_last_sms['group_id'] && $_insert['group_id'])
				{
					$update['group_id'] = $_insert['group_id'];
				}

				if(!$get_last_sms['recommend_id'] && $_insert['recommend_id'])
				{
					$update['recommend_id'] = $_insert['recommend_id'];
				}

				\lib\db\sms::update($update, $get_last_sms['id']);
				return intval($get_last_sms['id']);
			}
		}

		$id = \lib\db\sms::insert($_insert);
		return $id;
	}


	private static function check_need_analyze(&$insert)
	{
		$number       = $insert['fromnumber'];
		$mobileNumber = \dash\utility\filter::mobile($number);

		if($mobileNumber)
		{
			$get = \lib\db\smsgroupfilter::get(['type' => 'number', '1.1' => [" = 1.1" , "AND ( `number` = '$number' OR `number` = '$mobileNumber') "], 'limit' => 1]);
		}
		else
		{
			$get = \lib\db\smsgroupfilter::get(['type' => 'number', 'number' => $number, 'limit' => 1]);
		}


		// this number not found in any filter
		if(isset($get['group_id']))
		{

			$insert['group_id'] = $get['group_id'];

			$get_group = \lib\db\smsgroup::get(['id' => $get['group_id'], 'limit' => 1]);

			if(isset($get_group['status']) && $get_group['status'] === 'enable')
			{
				if(array_key_exists('analyze', $get_group) && !$get_group['analyze'])
				{
					$insert['receivestatus']  = 'block';
				}
			}
		}

		$text = $insert['text'];

		$split_text = explode(" ", $text);
		if($split_text && is_array($split_text))
		{
			$sql_text = "('". implode("','", $split_text). "')";
			$get_recommend = \lib\db\smsgroupfilter::get(['type' => 'analyze', 'text' => ["IN", $sql_text], 'limit' => 1]);
			if(isset($get_recommend['id']))
			{
				$insert['recommend_id'] = $get_recommend['group_id'];
			}
		}

	}
}
?>