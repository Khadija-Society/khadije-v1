<?php
namespace content\f;


class controller
{
	public static function routing()
	{
		if(!\dash\url::child())
		{
			\dash\header::status(404);
		}

		$festival_slug = \dash\url::child();

		$get_detail = \lib\db\festivals::get(['slug' => $festival_slug, 'limit' => 1]);
		if($get_detail)
		{
			\dash\open::get();
		}
		\dash\data::festival($get_detail);
	}
}
?>
