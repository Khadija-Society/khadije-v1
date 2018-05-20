<?php
namespace content\book;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Majaraye eshge man"));
		\dash\data::page_desc(T_("Download"). ' '. \dash\data::page_title());
	}
}
?>