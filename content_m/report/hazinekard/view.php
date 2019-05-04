<?php
namespace content_m\report\hazinekard;


class view
{
	public static function config()
	{
		\dash\permission::access('cpChartCountTransaction');

		\dash\data::page_pictogram('chart');


		\dash\data::page_title(T_('Report by payment and hazinekard'));
		// \dash\data::page_desc(T_('Sale your product via Jibres and enjoy using integrated web base platform.'));

		\dash\data::badge_text(T_('Back to report list'));
		\dash\data::badge_link(\dash\url::this());


		$result = \lib\app\report::hazinekard();

		\dash\data::chartTable($result);



	}
}
?>
