<?php
namespace content_api\v6\smsapp;


class newsms
{

	public static function add_new_sms()
	{
		// check gateway to not run this application in other device
		$gateway = \dash\request::post('gateway');
		\content_api\v6\smsapp\controller::check_allow_gateway($gateway);


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


		$insert                   = [];
		$insert['fromnumber']     = $from;
		$insert['togateway']      = $gateway;
		$insert['fromgateway']    = null;
		$insert['tonumber']       = null;
		$insert['user_id']        = null;
		$insert['date']           = date("Y-m-d H:i:s", strtotime($date));
		$insert['text']           = $text;
		$insert['uniquecode']     = null;
		$insert['reseivestatus']  = 'awaiting';
		$insert['sendstatus']     = null;
		$insert['amount']         = null;
		$insert['answertext']     = null;
		$insert['group_id'] = null;
		$insert['recomand_id']    = null;

		self::check_need_analyze($insert);

		$id = \lib\db\sms::insert($insert);

		if($insert['group_id'])
		{
			\lib\db\smsgroup::update_group_count($insert['group_id']);
		}

		if($id)
		{
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
		if(!isset($get['group_id']))
		{
			return;
		}

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
}
?>