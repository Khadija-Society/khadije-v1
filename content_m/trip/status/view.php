<?php
namespace content_m\trip\status;


class view
{
	public static function config()
	{
		\dash\permission::access('cpTripView');

		\dash\data::page_pictogram('magic');

		\dash\data::page_title(T_("Change status of trip"));
		\dash\data::page_desc(' ');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to request list'));

	}
}
?>
