<?php
namespace lib\app\log\caller;



class karbalaSignupCounter
{



	public static function site($_args = [])
	{
		$code = isset($_args['data']['countall']) ? $_args['data']['countall'] : null;

		$result              = [];
		$result['title']     = T_("Signup karbala");
		$result['icon']      = 'heart';
		$result['cat']       = T_("Signup");
		$result['iconClass'] = 'fc-green';
		$result['txt']       = "تعداد ثبت‌نامی‌های کربلا به عدد ". \dash\utility\human::number($code). " رسید.";
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

	public static function send_to()
	{
		return ['supervisor'];
	}

	public static function sms()
	{
		return false;
	}


	public static function sms_text($_args, $_mobile)
	{
		$code = isset($_args['data']['countall']) ? $_args['data']['countall'] : null;
		$sms =
		[
			'mobile' => $_mobile,
			'text'   => "تعداد ثبت‌نامی‌های کربلا به عدد ". \dash\utility\human::number($code). " رسید.",
			'meta'   =>
			[
				'footer' => false
			]
		];
		return json_encode($sms, JSON_UNESCAPED_UNICODE);

	}


	public static function telegram_text($_args, $_chat_id)
	{
		$code = isset($_args['data']['countall']) ? $_args['data']['countall'] : null;
		$tg_msg = '';
		$tg_msg .= "#SignupKarbala\n";
		$tg_msg .= "تعداد ثبت‌نامی‌های کربلا به عدد ". \dash\utility\human::number($code). " رسید.";
		$tg_msg .= "\n⏳ ". \dash\datetime::fit(date("Y-m-d H:i:s"), true);

		$tg                 = [];
		$tg['chat_id']      = $_chat_id;
		$tg['text']         = $tg_msg;
		// $tg['reply_markup'] = \dash\app\log\support_tools::tg_btn2($code);
		$tg = json_encode($tg, JSON_UNESCAPED_UNICODE);
		return $tg;

	}
}
?>