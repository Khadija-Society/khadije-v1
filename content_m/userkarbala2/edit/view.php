<?php
namespace content_m\userkarbala2\edit;

class view
{

	public static function config()
	{
		\dash\permission::access('koyeMohebbat');
		\dash\data::page_pictogram('atom');
		\dash\data::page_title('ویرایش نام و نام خانوادگی');


		\dash\data::badge_text(T_('Back'));

		\dash\data::badge_link(\dash\url::this(). '/show?level='. \dash\request::get('level'));


	}
}
?>