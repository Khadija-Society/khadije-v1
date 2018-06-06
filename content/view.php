<?php
namespace content;

class view
{
	public static function config()
	{
		\dash\data::site_title(T_("Khadije Charity"));
		\dash\data::site_desc(T_("Executor of first pilgrimage to the Ahl al-Bayt"));
		\dash\data::site_slogan(\dash\data::site_desc());

		\dash\data::page_desc(\dash\data::site_desc(). ' | '. \dash\data::site_slogan());

		// for pushstate of main page
		// \dash\data::template_xhr('content/main/layout-xhr.html');
	}
}
?>