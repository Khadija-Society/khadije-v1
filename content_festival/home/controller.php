<?php
namespace content_festival\home;


class controller
{
	public static function routing()
	{
		if(!\dash\url::module())
		{
			$festival_list = \lib\db\festivals::get(['status' => [" IN ", "('enable', 'expire')"]]);

			if(!$festival_list)
			{
				\dash\header::status(404, T_("No festival was found"));
			}
			\dash\data::allFestivalList($festival_list);
		}
		else
		{
			$festival_slug = \dash\url::module();

			$get_detail = \lib\db\festivals::get(['slug' => $festival_slug, 'limit' => 1]);
			if($get_detail)
			{
				\dash\open::get();
			}
			\dash\data::festival($get_detail);
		}
	}
}
?>
