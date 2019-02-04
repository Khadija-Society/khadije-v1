<?php
namespace content_cp\userkarbala\report;


class controller
{
	public static function routing()
	{
		\dash\permission::access('cpUsersKarbalaView');

		$subchild = \dash\url::subchild();
		if(in_array($subchild, ['provincelist', 'map']))
		{
			\dash\open::get();
		}

	}
}
?>
