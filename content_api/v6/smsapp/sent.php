<?php
namespace content_api\v6\smsapp;


class sent
{
	public static function set()
	{
		$smsid = \dash\request::post('smsid');
		$smsid = \dash\coding::decode($smsid);
		if(!$smsid)
		{
			\dash\notif::error(T_("Invalid sms id"));
			return false;
		}

		$load = \lib\db\sms::get(['s_sms.id' => $smsid, 'limit' => 1]);

		if(!isset($load['id']) || !isset($load['sendstatus']))
		{
			\dash\notif::error(T_("Sms id not found"));
			return false;
		}

		if($load['sendstatus'] === 'sendtodevice')
		{
			\lib\db\sms::update(['sendstatus' => 'send', 'datesend' => date("Y-m-d H:i:s"), 'tonumber' => $load['fromnumber']], $smsid);
			\dash\notif::ok(T_("The message set as sent message"));
			return ['dashboard' => \lib\app\sms::dashboard_quick(\dash\utility\filter::mobile(\dash\header::get('gateway')))];
		}
		else
		{
			\dash\notif::error(T_("This message is not ready to save as sent message"));
			return false;
		}

	}
}
?>