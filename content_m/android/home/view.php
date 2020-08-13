<?php
namespace content_m\android\home;


class view
{
	public static function config()
	{

		\dash\permission::access('mhomevideo');

		\dash\data::page_title('تنظیمات صفحه اول اپلیکیشن');

		\dash\data::page_pictogram('cogs');


		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));
		\dash\data::androidhomepage(\lib\app\androidhomepage::get());

	}
}
?>