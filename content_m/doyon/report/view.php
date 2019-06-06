<?php
namespace content_m\doyon\report;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDonateOption');

		\dash\data::page_pictogram('chart');

		\dash\data::page_title(T_("Doyon report"));

		\dash\data::badge_link(\dash\url::here(). '/doyon');
		\dash\data::badge_text(T_('Back to doyon list'));

		$masterChart = \lib\app\doyon::chart();
		\dash\data::masterChart($masterChart);
	}
}
?>
