<?php
namespace content_api\v6\delneveshte;


class controller
{
	public static function routing()
	{
		if(!\dash\request::is('get'))
		{
			\content_api\v6::no(404);
		}

		\content_api\v6::check_appkey();

		$list = self::delneveshte();

		\content_api\v6::bye($list);
	}

	private static function delneveshte()
	{
		$new = [];
		$list = \content_delneveshte\home\view::delneveshte_list();
		if(is_array($list))
		{
			foreach ($list as $key => $value)
			{
				$temp            = [];
				$temp['id']      = isset($value['id']) ? $value['id'] : null;
				$temp['content'] = isset($value['content']) ? $value['content'] : null;
				$temp['plus']    = isset($value['plus']) ? $value['plus'] : null;
				$new[] = $temp;
			}
		}

		return $new;
	}
}
?>