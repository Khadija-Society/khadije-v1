<?php
namespace content_cp\health\view;


class view
{
	public static function config()
	{
		\dash\permission::access('cpHealthChangeStatus');

		\dash\data::page_title(T_("View health detail"));
		\dash\data::page_desc(T_("check health and update status"));

		\dash\data::badge_link(\dash\url::here(). '/health');
		\dash\data::badge_text(T_('Back to health list'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
	}
}
?>
