<?php
namespace content_cp\consulting\view;


class view
{
	public static function config()
	{
		\dash\permission::access('cpRepresentationChangeStatus');

		\dash\data::page_title(T_("View consulting detail"));
		\dash\data::page_desc(T_("check consulting and update status"));

		\dash\data::badge_link(\dash\url::here(). '/consulting');
		\dash\data::badge_text(T_('Back to consulting list'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
	}
}
?>
