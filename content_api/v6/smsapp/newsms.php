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
			return false;
		}

		$text        = \dash\request::post('text');

		$date        = \dash\request::post('date');

		if($date && !strtotime($date))
		{
			\dash\notif::error(T_("Invalid date"));
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
			return false;
		}

		$insert               = [];
		$insert['fromnumber'] = $from;
		$insert['togateway']     = \dash\header::get('gateway');
		$insert['fromgateway']   = null;
		$insert['tonumber']      = null;
		$insert['user_id']       = $user_id;
		$insert['date']          = date("Y-m-d H:i:s", strtotime($date));
		$insert['text']          = $text;
		$insert['uniquecode']    = null;
		$insert['reseivestatus'] = 'awaiting';
		$insert['sendstatus']    = null;
		$insert['amount']        = null;
		$insert['answertext']    = null;
		$insert['group_id']      = null;
		$insert['recommend_id']   = null;

		$log = $insert;
		$log['mydate']    = $log['date'];
		$log['myuser_id'] = $log['user_id'];
		$log['mytext']    = $log['text'];

		unset($log['date']);
		unset($log['user_id']);
		unset($log['text']);

		self::check_need_analyze($insert);

		$id = \lib\db\sms::insert($insert);

		if($insert['group_id'])
		{
			\lib\db\smsgroup::update_group_count($insert['group_id']);
		}

		if($id)
		{
			$log['myid'] = $id;
			$log['code'] = $id;
			\dash\log::set('smsappNew', $log);
			\dash\notif::ok(T_("Message saved"));
			return ['smsid' => \dash\coding::encode($id)];
		}
		return false;
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
					$insert['reseivestatus']  = 'block';
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