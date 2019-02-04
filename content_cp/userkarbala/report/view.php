<?php
namespace content_cp\userkarbala\report;


class view
{
	public static function config()
	{
		\dash\permission::access('cpUsersKarbalaView');

		\dash\data::page_pictogram('chart');

		\dash\data::page_title(T_('Report'));
		// \dash\data::page_desc(T_('Sale your product via Jibres and enjoy using integrated web base platform.'));

		\dash\data::badge_text(T_('Back'));
		\dash\data::badge_link(\dash\url::this());


		\dash\data::include_highcharts(false);
		$chartProvinceData = \lib\app\karbalauser::chart_province();

		\dash\data::chartProvinceData($chartProvinceData);

	}
}
?>
