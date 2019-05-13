<?php
namespace lib;

class cronjob
{
	public static function run()
	{
		switch (\dash\request::get('type'))
		{
			case 'thankyoumessage':
				self::thankyoumessage();
				break;

			case 'smsapp':
				self::smsapp();
				break;

			default:
				# code...
				break;
		}
	}

	private static function smsapp()
	{
		\lib\app\sms::send_notif();
		\lib\app\sms::send_sms_panel();
		\lib\app\sms::send_auto_answered();

	}


	private static function thankyoumessage()
	{
		if(date("H:i") !== '11:00' && !\dash\permission::supervisor())
		{
			return;
		}

		$message = \lib\app\message::get();

		if(isset($message['active']) && $message['active'])
		{
			$user_list = \lib\db\thankyoumessage::list();

			if($user_list && is_array($user_list))
			{
				$user_id = array_column($user_list, 'id');
				$user_id = array_filter($user_id);
				$user_id = array_unique($user_id);
				if($user_id)
				{
					\dash\log::set('tankyouMessage', ['to' => $user_id]);
					\lib\db\thankyoumessage::sended(array_column($user_list, 'id'));

				}
			}
		}
		else
		{
			return false;
		}

	}
}
?>
