<?php
namespace content_m\representation\view;


class view
{
	public static function config()
	{
		\dash\permission::access('cpRepresentationChangeStatus');

		\dash\data::page_title(T_("View representation detail"));
		\dash\data::page_desc(T_("check representation and update status"));

		\dash\data::badge_link(\dash\url::here(). '/representation');
		\dash\data::badge_text(T_('Back to representation list'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
	}
}
?>
