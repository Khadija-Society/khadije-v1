<?php
namespace content_m\doyon\view;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("View doyon detail"));
		\dash\data::page_desc(T_("check doyon and update status"));

		\dash\data::badge_link(\dash\url::here(). '/doyon');
		\dash\data::badge_text(T_('Back to doyon list'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
	}
}
?>
