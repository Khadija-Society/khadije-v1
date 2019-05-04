<?php
namespace content_m\myhomepage;

class view
{
	public static function config()
	{
		\dash\data::page_pictogram('display');
		\dash\data::page_title(T_("Khadije Homepage Dashboard"));
		\dash\data::page_desc(T_("Khadije Homepage Dashboard"));
	}
}
?>