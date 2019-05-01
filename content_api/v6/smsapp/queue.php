<?php
namespace content_api\v6\smsapp;


class queue
{
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

		// get 10 sms
		return $must_be_send;

	}


	private static function must_be_send()
	{
		$get = \lib\db\sms::get(['sendstatus' => 'awaiting', 'limit' => 10]);

		if($get)
		{
			// set all record as sent to device
			$id = array_column($get, 'id');
			$id = implode(',', $id);
			\lib\db\sms::update_where(['sendstatus' => 'sendtodevice'], ['id' => ["IN", "($id)"]]);

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