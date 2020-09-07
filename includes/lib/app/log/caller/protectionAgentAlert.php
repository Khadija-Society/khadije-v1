<?php
namespace lib\app\log\caller;



class protectionAgentAlert
{

	private static function my_text()
	{
		return 'سلام. نماینده گرامی لطفا جهت ثبت اطلاعات افراد تحت پوشش خود به وب‌سایت موسسه حضرت خدیجه مراجعه کنید';
	}

	public static function site($_args = [])
	{
		$code = isset($_args['data']['countall']) ? $_args['data']['countall'] : null;

		$result              = [];
		$result['title']     = T_("Agent occasion alert");
		$result['icon']      = 'heart';
		$result['cat']       = T_("Signup");
		$result['iconClass'] = 'fc-green';
		$result['txt']       = self::my_text();
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
		$code = isset($_args['data']['countall']) ? $_args['data']['countall'] : null;
		$sms =
		[
			'mobile' => $_mobile,
			'text'   => self::my_text(),
			'meta'   =>
			[
				'footer' => true
			]
		];
		return json_encode($sms, JSON_UNESCAPED_UNICODE);

	}


	public static function telegram_text($_args, $_chat_id)
	{
		$code = isset($_args['data']['countall']) ? $_args['data']['countall'] : null;
		$tg_msg = '';
		$tg_msg .= "#SignupAgent\n";
		$tg_msg .= self::my_text();
		$tg_msg .= "\n⏳ ". \dash\datetime::fit(date("Y-m-d H:i:s"), true);

		$tg                 = [];
		$tg['chat_id']      = $_chat_id;
		$tg['text']         = $tg_msg;
		// $tg['reply_markup'] = \dash\app\log\support_tools::tg_btn2($code);
		// $tg = json_encode($tg, JSON_UNESCAPED_UNICODE);
		return $tg;

	}
}
?>