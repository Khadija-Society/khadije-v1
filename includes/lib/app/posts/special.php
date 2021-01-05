<?php
namespace lib\app\posts;


class special
{

	public static function list()
	{
		$list             = [];
		$list['slider']   = T_("Slider");
		$list['promotion']   = T_("Promotion");
		return $list;
	}


}
?>