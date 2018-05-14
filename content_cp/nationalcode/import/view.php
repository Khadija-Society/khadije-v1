<?php
namespace content_cp\nationalcode\import;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Import national code"));
		\dash\data::page_desc(T_("Import list of national code, each line must have one nationalcode"));
		\dash\data::bodyclass('unselectable');
		\dash\data::include_siftal(true);
		\dash\data::include_css(false);
	}
}
?>
