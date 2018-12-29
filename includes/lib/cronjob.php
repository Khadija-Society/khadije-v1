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
		if($user_list && is_array($user_list))
		{

		}

	}
}
?>
