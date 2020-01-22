<?php
namespace lib\app\log\caller;


class servantAssessment
{
	public static function site($_args = [])
	{

		$result              = [];
		$result['title']     = "جهت تکمیل ارزیابی خادمین کلیک کنید";
		$result['icon']      = 'search';
		$result['cat']       = T_("Servant");
		$result['iconClass'] = 'fc-green';


		$excerpt = '';
		$excerpt .=	'<a href="'.\dash\url::kingdom(). '/a/servant">';
		$excerpt .= "ارزیابی خادمنی";
		$excerpt .= '</a>';

		$result['txt'] = $excerpt;

		return $result;
	}

	public static function expire()
	{
		return date("Y-m-d H:i:s", strtotime("+100 days"));
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
		$title = "خادم گرام. جهت تکمیل ارزیابی به لینک زیر مراجعه فرمایید";
		$title .= "\n";
		$title .= \dash\url::kingdom(). '/a/servant';


		$sms =
		[
			'mobile' => $_mobile,
			'text'   => $title,
			'meta'   =>
			[
				'footer' => false
			]
		];

		return json_encode($sms, JSON_UNESCAPED_UNICODE);
	}


	public static function telegram_text($_args, $_chat_id)
	{

		$title = "جهت تکمیل ارزیابی خادم کلیک کنید";

		$tg_msg = '';
		$tg_msg .= "#servant";
		$tg_msg .= "\n". $title;
		$tg_msg .= "\n⏳ ". \dash\datetime::fit(date("Y-m-d H:i:s"), true);

		// disable footer in sms
		// $msg['send_msg']['footer']   = false;

		$tg                 = [];
		$tg['chat_id']      = $_chat_id;
		$tg['text']         = $tg_msg;


		// $tg = json_encode($tg, JSON_UNESCAPED_UNICODE);

		return $tg;
	}
}
?>