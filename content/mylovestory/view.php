<?php
namespace content\mylovestory;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("My Love Story"));
		\dash\data::page_desc(T_("Download"). ' '. \dash\data::page_title());
	}
}
?>