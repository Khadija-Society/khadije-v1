<?php
namespace content_cp\report\whitname;


class view
{
	public static function config()
	{
		\dash\permission::access('cpChartCountTransaction');

		\dash\data::page_pictogram('chart');

		\dash\data::include_chart(true);

		\dash\data::page_title(T_('Report pay by name'));
		// \dash\data::page_desc(T_('Sale your product via Jibres and enjoy using integrated web base platform.'));

		\dash\data::badge_text(T_('Back to report list'));
		\dash\data::badge_link(\dash\url::this());


		$result = \lib\app\report::whitname();
		\dash\data::chartTable($result);
		\dash\data::chartResult(json_encode($result, JSON_UNESCAPED_UNICODE));


	}
}
?>
