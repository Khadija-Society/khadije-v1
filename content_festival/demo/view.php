<?php
namespace content_festival\demo;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("جشنواره بانوی نبی پسند"));
		\dash\data::page_desc('طراح گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد. ');
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
