<?php
namespace lib;

class cronjob
{
	public static function run()
	{
		self::verify_zarinpal();

		self::thankyoumessage();

		self::smsapp();


		self::remove_log();

	}



	private static function verify_zarinpal()
	{
		// if(intval(date("Hi")) === 1905)
		// {

		// 	$get_list = \dash\db\transactions::get(['condition' => [' != ', " 'ok' "], 'payment' => 'zarinpal'], ['public_show_field' => 'id']);

		// 	if($get_list)
		// 	{
		// 		foreach ($get_list as $key => $value)
		// 		{
		// 			\dash\app\transaction\edit::verify_again($value['id']);
		// 		}
		// 	}
		// }
	}

	private static function smsapp()
	{
		\lib\app\sms::send_auto_answered();
		\lib\app\sms::send_notif();
		\lib\app\sms::send_sms_panel();

	}


	private static function remove_log()
	{
		if(date("H:i") !== '17:00' && !\dash\permission::supervisor())
		{
			return;
		}

		$exec = "mysql -u'". db_user. "' -p'". db_pass. "' ". db_log_name. ' -e "TRUNCATE \`apilog\`" ';

		shell_exec($exec);

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
