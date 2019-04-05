<?php
namespace content_cp\trip\view;


class view
{
	public static function config()
	{
		\dash\permission::access('cpTripView');

		\dash\data::page_pictogram('user-secret');

		\dash\data::page_title(T_("View request detail"));
		\dash\data::page_desc(' ');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to request list'));
	}
}
?>
