<?php
namespace content_mokeb;

class view
{
	public static function config()
	{

		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);
		\dash\data::include_js(false);

		\dash\data::include_highcharts(true);


		\dash\data::include_editor(true);
		\dash\data::badge_shortkey(120);
		\dash\data::badge2_shortkey(121);

		\dash\data::maxUploadSize(\dash\utility\upload::max_file_upload_size(true));


		$args =
		[
			'pagenation' => false,
			'status' => 'enable',

		];
		$list = \lib\app\place::list(null, $args);
		$list = \lib\app\mokebuser::place_dashboard($list);
		\dash\data::mokebList($list);

	}
}
?>