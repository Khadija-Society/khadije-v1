<?php
namespace content_cp\meeting\add;


class view
{
	public static function config()
	{
		\dash\permission::access('cpMeetingAdd');

		\dash\data::page_pictogram('cogs');

		\dash\data::page_title(T_("Add new meeting report"));
		\dash\data::page_desc(T_("Fill the field below and add new meeting report"));
		\dash\data::badge_link(\dash\url::here(). '/meeting');
		\dash\data::badge_text(T_('Back to meeting report list'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
	}

}
?>
