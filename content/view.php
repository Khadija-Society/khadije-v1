<?php
namespace content;

class view
{
	public static function config()
	{

		\dash\data::site_title(T_("Khadije Charity"));
		// if(\dash\url::isLocal())
		// {
		// 		\dash\data::site_title(T_("Test"));
		// }
		\dash\data::site_desc(T_("Executor of first pilgrimage to the Ahl al-Bayt"));

		\dash\data::site_slogan(\dash\data::site_desc());

		\dash\data::page_desc(\dash\data::site_desc(). ' | '. \dash\data::site_slogan());

		\dash\data::bodyclass(null);

		// for pushstate of main page
		\dash\data::template_xhr('content/main/layout-xhr.html');
		\dash\data::display_admin('content_a/main/layout.html');
		\dash\data::template_social('content/template/social.html');
		\dash\data::template_share('content/template/share.html');


		// if(\dash\url::content() === null)
		// {
		// 	// get total uses
		// 	$total_users                     = 10; // intval(\lib\db\userteams::total_userteam());
		// 	$total_users                     = number_format($total_users);
		// 	$total_users         = \dash\utility\human::number($total_users);
		// 	\dash\data::footerStat(T_("We help :count people to work beter!", ['count' => $total_users]));
		// }

		// if you need to set a class for body element in html add in this value
	}
}
?>