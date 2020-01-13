<?php
namespace content_agent\place\add;


class view
{
	public static function config()
	{
		\dash\permission::access('mPlaceAdd');
		\dash\data::page_title(T_("Add new place"));
		\dash\data::page_pictogram('plus-circle');
		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));
	}
}
?>