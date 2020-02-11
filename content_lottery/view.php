<?php
namespace content_lottery;


class view
{
	public static function config()
	{
		// \dash\data::include_css(true);
		// \dash\data::include_js(true);
		\dash\data::include_adminPanel(true);
		\dash\data::include_highcharts(true);

		\dash\data::display_admin('content_lottery/layout.html');
	}
}
?>
