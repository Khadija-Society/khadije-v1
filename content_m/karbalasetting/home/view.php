<?php
namespace content_m\karbalasetting\home;


class view
{
	public static function config()
	{

		\dash\permission::access('mKarbalaSetting');

		\dash\data::page_title('فعال یا غیر فعال سازی ثبت‌نام کربلا');

		\dash\data::page_pictogram('cogs');


		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));
		\dash\data::karbalasettingSaved(\lib\app\karbalasetting::get());

	}
}
?>