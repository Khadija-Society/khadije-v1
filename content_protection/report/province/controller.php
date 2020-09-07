<?php
namespace content_protection\report\province;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonReport');
	}
}
?>