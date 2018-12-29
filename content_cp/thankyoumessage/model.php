<?php
namespace content_cp\thankyoumessage;


class model
{
	public static function post()
	{
		\dash\permission::access('aSettingSmsEdit');
		$text   = \dash\request::post('text');
		$sms    = \dash\request::post('sms');
		$active = \dash\request::post('active');

		$setting =
		[
			'active' => $active,
			'sms'    => $sms,
		];

		$result = \lib\app\message::set($text, $setting);
		if($result)
		{
			\dash\log::set('MessageChanged');
			\dash\notif::ok(T_("Message saved"));
		}

	}
}
?>