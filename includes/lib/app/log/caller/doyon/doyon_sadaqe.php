<?php
namespace lib\app\log\caller\doyon;



class doyon_sadaqe
{

	private static function myDetail($_args)
	{
		$result                = [];
		$result['type']        = isset($_args['data']['detail']['type']) ? $_args['data']['detail']['type'] : null;
		$result['title']       = isset($_args['data']['detail']['title']) ? $_args['data']['detail']['title'] : null;
		$result['seyyed']      = isset($_args['data']['detail']['seyyed']) ? $_args['data']['detail']['seyyed'] : null;
		$result['count']       = isset($_args['data']['detail']['count']) ? $_args['data']['detail']['count'] : null;
		$result['priceone']    = isset($_args['data']['detail']['priceone']) ? $_args['data']['detail']['priceone'] : null;
		$result['price']       = isset($_args['data']['detail']['price']) ? $_args['data']['detail']['price'] : null;
		$result['status']      = isset($_args['data']['detail']['status']) ? $_args['data']['detail']['status'] : null;
		$result['subtitle']    = isset($_args['data']['detail']['subtitle']) ? $_args['data']['detail']['subtitle'] : null;
		$result['datecreated'] = isset($_args['data']['detail']['datecreated']) ? $_args['data']['detail']['datecreated'] : null;
		$result['fullname']    = isset($_args['data']['detail']['fullname']) ? $_args['data']['detail']['fullname'] : null;
		$result['saheb']       = isset($_args['data']['detail']['saheb']) ? $_args['data']['detail']['saheb'] : null;
		return $result;

	}


	private static function myTitle($_args)
	{
		extract(self::myDetail($_args));
		$title = '';
		$title .= 'مبلغ ';
		$title .= \dash\utility\human::fitNumber($price);
		$title .= ' تومان بابت ';
		$title .= T_($type) ;
		$title .= ' دریافت شد';
		return $title;
	}


	public static function site($_args = [])
	{
		extract(self::myDetail($_args));

		$result              = [];
		$result['title']     = $title;
		$result['icon']      = 'garden';
		$result['cat']       = T_("Doyon");
		$result['iconClass'] = 'fc-blue';
		$result['txt']       = self::myTitle($_args);
		return $result;

	}

	public static function expire()
	{
		return date("Y-m-d H:i:s", strtotime("+30 days"));
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
		return false;
	}


	public static function sms_text($_args, $_mobile)
	{

		$sms =
		[
			'mobile' => $_mobile,
			'text'   => self::myTitle($_args),
			'meta'   =>
			[
				'footer' => false
			]
		];
		return json_encode($sms, JSON_UNESCAPED_UNICODE);

	}


	public static function telegram_text($_args, $_chat_id)
	{

		$tg_msg = '';
		$tg_msg .= "#Doyon\n";
		$tg_msg .= self::myTitle($_args);
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