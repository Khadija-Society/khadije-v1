<?php
namespace content_a\protection\occasion;


class view
{
	public static function config()
	{

		\dash\data::page_title("ثبت اطلاعات افراد تحت پوشش");


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));


	}

}
?>
