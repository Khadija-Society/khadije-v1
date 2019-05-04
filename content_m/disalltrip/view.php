<?php
namespace content_m\disalltrip;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDisableAllTrip');


		\dash\data::page_pictogram('cog');

		\dash\data::page_title(T_("Disalbel all trip"));
		\dash\data::page_desc(T_("Danger"));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		\dash\data::tripCount(\lib\db\travels::show_count_trip('family'));

	}
}
?>
