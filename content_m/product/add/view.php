<?php
namespace content_m\product\add;


class view
{
	public static function config()
	{
		\dash\permission::access('mProductAdd');
		\dash\data::page_title(T_("Add new product"));
		\dash\data::page_pictogram('plus-circle');
		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));
	}
}
?>