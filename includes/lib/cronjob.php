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

			default:
				# code...
				break;
		}
	}


	private static function thankyoumessage()
	{
		if(date("H:i") !== '08:00')
		{
			// return;
		}

		$user_list = \lib\db\thankyoumessage::list();
		if($list && is_array($list))
		{

		}
		var_dump($user_list);
		// set log for all user payed 1 years ago
		// tankyouMessage
		// rememberdate

		var_dump(1);exit();
	}
}
?>
