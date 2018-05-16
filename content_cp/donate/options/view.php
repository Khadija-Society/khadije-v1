<?php
namespace content_cp\donate\options;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDonateOption');

		\dash\data::page_title(T_("Donation options"));
		\dash\data::page_desc(T_("check and update some options on donations"));
		\dash\data::badge_link(\dash\url::here(). '/donate');
		\dash\data::badge_text(T_('Back to donate list'));
		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
		\dash\data::wayList(\lib\app\donate::way_list());
	}
}
?>
