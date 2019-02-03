<?php
namespace lib\app\log\caller;



class karbalaUsersExportCsvFile
{



	public static function site($_args = [])
	{

		$fileaddr = isset($_args['data']['fileaddr']) ? $_args['data']['fileaddr'] : null;

		$msg = T_("Create export file completed");
		$msg .= '<a href="'. $fileaddr. '" download > <b>'. T_("To download it click here"). '</b> </a>';
		$msg .= '<br>'. T_("This file will be automatically deleted for a few minutes");

		$result              = [];
		$result['title']     = T_("Export karbala users");
		$result['icon']      = 'file';
		$result['cat']       = T_("Export");
		$result['iconClass'] = 'fc-blue';
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
		return ['supervisor', 'admin'];
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
			'text'   => "تعداد ثبت‌نامی‌های کربلا به عدد ". \dash\utility\human::fitNumber($code). " رسید.",
			'meta'   =>
			[
				'footer' => false
			]
		];
		return json_encode($sms, JSON_UNESCAPED_UNICODE);

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
		// $tg['reply_markup'] = \dash\app\log\support_tools::tg_btn2($code);
		// $tg = json_encode($tg, JSON_UNESCAPED_UNICODE);
		return $tg;

	}
}
?>