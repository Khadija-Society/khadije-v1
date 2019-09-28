<?php
namespace content_mokeb\choose;


class view
{
	public static function config()
	{
		\dash\data::page_title("انتخاب محل موکب");
		$args =
		[
			'pagenation' => false,
			'status' => 'enable',

		];
		$list = \lib\app\place::list(null, $args);
		\dash\data::mokebList($list);
	}
}
?>
