<?php
namespace lib\app\log\caller;



class karbalaUserSignup
{

	private static $text = "زائر گرامی\nثبت نام شما انجام شد\nثبت نام به منزله اعزام نمیباشد\nسمت خدا";

	public static function site($_args = [])
	{

			$result              = [];
			$result['title']     = T_("Signup karbala");
			$result['icon']      = 'heart';
			$result['cat']       = T_("Signup");
			$result['iconClass'] = 'fc-green';
			$result['txt']       = self::$text;
			return $result;

	}

	public static function expire()
	{
		return date("Y-m-d H:i:s", strtotime("+365 days"));
	}


	public static function is_notif()
	{
		return true;
	}


	public static function telegram()
	{
		return true;
	}


	public static function sms()
	{
		return true;
	}


	public static function sms_text($_args, $_mobile)
	{
		$sms =
		[
			'mobile' => $_mobile,
			'text'   => self::$text,
			'meta'   =>
			[
				'footer' => false
			]
		];
		return json_encode($sms, JSON_UNESCAPED_UNICODE);

	}


	public static function telegram_text($_args, $_chat_id)
	{
		$tg                 = [];
		$tg['chat_id']      = $_chat_id;
		$tg['text']         = self::$text;
		// $tg['reply_markup'] = \dash\app\log\support_tools::tg_btn2($code);
		$tg = json_encode($tg, JSON_UNESCAPED_UNICODE);
		return $tg;

	}
}
?>