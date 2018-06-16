<?php
namespace content_cp\myrequest;

class view
{
	public static function config()
	{
		\dash\data::page_pictogram('arrows-alt');
		\dash\data::page_title(T_("Khadije Request Dashboard"));
		\dash\data::page_desc(T_("Khadije Request Dashboard"));
	}
}
?>