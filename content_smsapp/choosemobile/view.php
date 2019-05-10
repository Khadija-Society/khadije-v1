<?php
namespace content_smsapp\choosemobile;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('question');

		\dash\data::page_title(T_("Choose gateway mobile"));

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Dashboard'));



	}
}
?>
