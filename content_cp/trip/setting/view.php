<?php
namespace content_cp\trip\setting;


class view
{
	public static function config()
	{
		\dash\permission::access('cpTripView');

		\dash\data::page_pictogram('cogs');

		\dash\data::page_title(T_("Travel setting"));
		\dash\data::page_desc(' ');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to request list'));

	}
}
?>
