<?php
namespace content_festival\demo;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("جشنواره بانوی نبی پسند"));
		\dash\data::page_desc('');
		\dash\data::include_css(false);
		\dash\data::include_js(false);

		\dash\data::display_delneveshte("content_festival/demo/layout.html");
		if(\dash\request::ajax())
		{
			\dash\data::display_delneveshte("content_festival/demo/messages.html");
		}
	}
}
?>
