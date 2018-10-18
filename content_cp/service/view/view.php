<?php
namespace content_cp\service\view;


class view
{
	public static function config()
	{
		\dash\permission::access('cpRepresentationChangeStatus');

		\dash\data::page_title(T_("View service detail"));
		\dash\data::page_desc(T_("check service and update status"));

		\dash\data::badge_link(\dash\url::here(). '/service');
		\dash\data::badge_text(T_('Back to service list'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
	}
}
?>
