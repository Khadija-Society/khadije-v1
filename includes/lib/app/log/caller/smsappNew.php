<?php
namespace lib\app\log\caller;



class smsappNew
{

	public static function myVar($_args)
	{
		$var                  = [];
		$var['fromnumber']    = isset($_args['data']['fromnumber']) ? $_args['data']['fromnumber'] : null;
		$var['togateway']     = isset($_args['data']['togateway']) ? $_args['data']['togateway'] : null;
		$var['fromgateway']   = isset($_args['data']['fromgateway']) ? $_args['data']['fromgateway'] : null;
		$var['tonumber']      = isset($_args['data']['tonumber']) ? $_args['data']['tonumber'] : null;
		$var['uniquecode']    = isset($_args['data']['uniquecode']) ? $_args['data']['uniquecode'] : null;
		$var['reseivestatus'] = isset($_args['data']['reseivestatus']) ? $_args['data']['reseivestatus'] : null;
		$var['sendstatus']    = isset($_args['data']['sendstatus']) ? $_args['data']['sendstatus'] : null;
		$var['amount']        = isset($_args['data']['amount']) ? $_args['data']['amount'] : null;
		$var['answertext']    = isset($_args['data']['answertext']) ? $_args['data']['answertext'] : null;
		$var['group_id']      = isset($_args['data']['group_id']) ? $_args['data']['group_id'] : null;
		$var['recommend_id']  = isset($_args['data']['recommend_id']) ? $_args['data']['recommend_id'] : null;
		$var['mydate']        = isset($_args['data']['mydate']) ? $_args['data']['mydate'] : null;
		$var['myuser_id']     = isset($_args['data']['myuser_id']) ? $_args['data']['myuser_id'] : null;
		$var['mytext']        = isset($_args['data']['mytext']) ? $_args['data']['mytext'] : null;
		return $var;
	}


	public static function site($_args = [])
	{

		$var = self::myVar($_args);

		$msg = T_("New message");
		$msg .= " ";
		$msg .= T_("From"). ' '. \dash\utility\human::fitNumber($var['fromnumber'], false);
		$msg .= " <br>";
		$msg .= $var['mytext'];


		$result              = [];
		$result['title']     = T_("New message");
		$result['icon']      = 'email';
		$result['cat']       = T_("Sms");
		$result['iconClass'] = 'fc-red';
		$result['txt']       = $msg;
		return $result;

	}

	public static function expire()
	{
		return date("Y-m-d H:i:s", time() + (60*30));
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
		return ['answerSmsApp', 'admin', 'supervisor'];
	}


	public static function sms()
	{
		return false;
	}


	public static function sms_text($_args, $_mobile)
	{
		return false;

		// $code = isset($_args['data']['countall']) ? $_args['data']['countall'] : null;
		// $sms =
		// [
		// 	'mobile' => $_mobile,
		// 	'text'   => "تعداد ثبت‌نامی‌های کربلا به عدد ". \dash\utility\human::fitNumber($code). " رسید.",
		// 	'meta'   =>
		// 	[
		// 		'footer' => false
		// 	]
		// ];
		// return json_encode($sms, JSON_UNESCAPED_UNICODE);
	}


	public static function telegram_text($_args, $_chat_id)
	{
		$fileaddr = isset($_args['data']['fileaddr']) ? $_args['data']['fileaddr'] : null;

		$msg = T_("Create export file completed");
		$msg .= '<a href="'. $fileaddr. '" download > <b>'. T_("To download it click here"). '</b> </a>';
		$msg .= T_("This file will be automatically deleted for a few minutes");

		$tg_msg = '';
		$tg_msg .= "#ExportKarbalaUsers\n";
		$tg_msg .= $msg;
		$tg_msg .= "\n⏳ ". \dash\datetime::fit(date("Y-m-d H:i:s"), true);

		$tg                 = [];
		$tg['chat_id']      = $_chat_id;
		$tg['text']         = $tg_msg;
		$tg['reply_markup'] =
		[
			'inline_keyboard'    =>
			[
				[
					[
						'text'          => 	T_("Check ticket"),
						'callback_data' => 'smsai '. 1233,
					],
				],
			],
		];
		// $tg = json_encode($tg, JSON_UNESCAPED_UNICODE);
		return $tg;

	}
}
?>