<?php
namespace content_m\homevideo\home;


class view
{
	public static function config()
	{

		\dash\permission::access('mhomevideo');

		\dash\data::page_title('تنظیمات نمایش ویدئو در صفحه اول');

		\dash\data::page_pictogram('cogs');


		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));
		\dash\data::homevideoSaved(\lib\app\homevideo::get());

	}
}
?>