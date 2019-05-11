<?php
namespace content_api\v6\smsapp;


class notsent
{
	public static function get()
	{
		// if status is active
		if(!\content_api\v6\smsapp\controller::status())
		{
			\dash\notif::warn(T_("The system is off"));
			return null;
		}

		// if have sms
		$not_sent = self::not_sent();

		if(!$not_sent)
		{
			\dash\notif::warn(T_("No not sent message"));
			return null;
		}

		// get 10 sms
		return $not_sent;

	}


	private static function not_sent()
	{
		$get_args =
		[
			'sendstatus'   => 'sendtodevice',
			// 'togateway' => \dash\utility\filter::mobile(\dash\header::get('gateway')),
			'fromgateway'  => \dash\utility\filter::mobile(\dash\header::get('gateway')),
			'limit'        => 10
		];

		$get = \lib\db\sms::get($get_args);

		if($get)
		{
			$get = array_map(["\\lib\\app\\sms", "ready"], $get);
			return $get;
		}

		return false;
	}


}
?>