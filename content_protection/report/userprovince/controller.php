<?php
namespace content_protection\report\userprovince;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonReport');
	}
}
?>