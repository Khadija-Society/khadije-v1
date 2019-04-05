<?php
namespace content_cp\trip\duplicate;


class view
{
	public static function config()
	{
		\dash\permission::access('cpTripView');

		\dash\data::page_pictogram('hand-peace-o');

		\dash\data::page_title(T_("Duplicate travel to another place"));
		\dash\data::page_desc(' ');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to request list'));

		$meta = \dash\data::travelDetail_meta();
		\dash\data::travelMeta($meta);
	}
}
?>
