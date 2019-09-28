<?php
namespace content_mokeb\add;


class controller
{
	public static function routing()
	{
		$child = \dash\url::child();
		if($child)
		{
			$load_place = \lib\app\place::get($child);
			if($load_place)
			{
				\dash\data::mokebDetail($load_place);
				\dash\open::get();
				\dash\open::post();
			}
		}
		else
		{
			\dash\redirect::to(\dash\url::here(). '/choose');
		}
	}
}
?>