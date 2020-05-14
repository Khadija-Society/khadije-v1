<?php
namespace content_smsapp\export;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('file-o');

		\dash\data::page_title("خروجی از پیامک‌ها");

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Dashboard'));



	}
}
?>
