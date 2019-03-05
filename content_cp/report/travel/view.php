<?php
namespace content_cp\report\travel;


class view
{
	public static function config()
	{
		\dash\permission::access('cpChartTravel');

		\dash\data::page_pictogram('chart');


		\dash\data::page_title(T_('Report travel'));
		// \dash\data::page_desc(T_('Sale your product via Jibres and enjoy using integrated web base platform.'));

		\dash\data::badge_text(T_('Back to report list'));
		\dash\data::badge_link(\dash\url::this());


		$result = \lib\app\report::travel();

		\dash\data::chartTable($result);



	}
}
?>
