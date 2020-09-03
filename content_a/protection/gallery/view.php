<?php
namespace content_a\protection\gallery;


class view
{
	public static function config()
	{

		\dash\data::page_title("ارائه گزارش تصویزی");


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$gallery = \dash\data::dataRow_gallery();
		$gallery = json_decode($gallery, true);
		\dash\data::dataTable($gallery);


	}

}
?>
