<?php
namespace content_a;

class view
{
	public static function config()
	{

		\dash\data::site_title(T_("Khadije Charity"));
		\dash\data::site_desc(T_("Executor of first pilgrimage to the Ahl al-Bayt"));
		\dash\data::site_slogan(\dash\data::site_desc());
		\dash\data::page_desc(\dash\data::site_desc(). ' | '. \dash\data::site_slogan());

		// for pushstate of main page
		\dash\data::template_xhr('content/main/layout-xhr.html');

		\dash\data::display_admin('content_a/main/layout.html');
		\dash\data::template_social('content/template/social.html');
		\dash\data::template_share('content/template/share.html');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
		\dash\data::include_js(false);
		\dash\data::bodyclass('fixed unselectable');

	}

}
?>