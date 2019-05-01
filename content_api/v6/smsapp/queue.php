<?php
namespace content_api\v6\smsapp;


class queue
{
	public static function get()
	{
		// if status is active
		if(!self::status())
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


	private static function status()
	{
		$addr = root.'includes/lib/app/smsapp.me.txt';
		$addr = \autoload::fix_os_path($addr);
		if(is_file($addr))
		{
			$get = \dash\file::read($addr);
			$get = json_decode($get, true);
			if(isset($get['status']) && $get['status'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$status =
			[
				'status' => true,
			];

			$status = json_encode($status, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

			\dash\file::write($addr, $status);
			return true;
		}

	}
}
?>