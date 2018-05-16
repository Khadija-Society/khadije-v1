<?php
namespace content_cp\homepage;


class view
{
	public static function config()
	{
		\dash\permission::access('cpHomePageNumber');

		\dash\data::page_title(T_("Homepage settings"));
		\dash\data::page_desc(T_("For show in home page"));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		$url = root. 'public_html/files/data/staticvar.txt';

		$result = @\dash\file::read($url);

		if(is_string($result))
		{
			$result                = explode("\n", $result);
			$temp                  = [];
			$temp['qom']           = isset($result[0]) ? $result[0] : null;
			$temp['mashhad']       = isset($result[1]) ? $result[1] : null;
			$temp['karbala']       = isset($result[2]) ? $result[2] : null;
			\dash\data::staticvar($temp);
		}
	}
}
?>
