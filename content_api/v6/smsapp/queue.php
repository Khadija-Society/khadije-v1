<?php
namespace content_api\v6\smsapp;


class queue
{
	private static $ids = [];


	public static function get()
	{
		// if status is active
		if(!\content_api\v6\smsapp\controller::status())
		{
			\dash\notif::warn(T_("The system is off"));
			return null;
		}

		// if no not sent sms
		if(self::not_sent_sms())
		{
			\dash\notif::warn(T_("You have some not sent sms, please send it before"));
			return null;
		}

		// if have sms
		$must_be_send = self::must_be_send();

		if(!$must_be_send)
		{
			\dash\notif::warn(T_("No new message"));
			return null;
		}


		if(self::check_max_limit())
		{
			\dash\notif::warn(T_("Maximum limit"));
			return null;
		}

		self::set_status_as_sendtodevice();

		// get 10 sms
		return $must_be_send;

	}


	private static function check_max_limit()
	{
		$max_limit = 450; // every day
		$gateway = \dash\header::get('gateway');
		$gateway = \dash\utility\filter::mobile($gateway);


		$get =
		[
			'cat'   => 'smsapp',
			'key'   => 'limit_'. date("Y-m-d"). '_'. $gateway,
			'limit' => 1,
		];

		$get = \dash\db\options::get($get);


		if(isset($get['value']) && intval($get['value']) >= $max_limit)
		{
			return true;
		}

		return false;
	}

	private static function set_status_as_sendtodevice()
	{
		if(self::$ids)
		{
			$id = self::$ids;
			\lib\db\sms::update_where(['sendstatus' => 'sendtodevice'], ['id' => ["IN", "($id)"]]);
		}
	}

	private static function must_be_send()
	{
		$get = \lib\db\sms::get(['sendstatus' => 'awaiting', 'limit' => 10]);

		if($get)
		{
			// set all record as sent to device
			$id = array_column($get, 'id');
			$id = implode(',', $id);
			self::$ids = $id;

			// ready to return
			$get = array_map(["\\lib\\app\\sms", "ready"], $get);
			return $get;
		}

		return false;
	}



	private static function not_sent_sms()
	{
		$get = \lib\db\sms::get(['sendstatus' => 'sendtodevice', 'limit' => 1]);

		if($get)
		{
			return true;
		}

		return false;
	}



}
?>