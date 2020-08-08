<?php
namespace content_a\protection\occasion;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Festival course list"));
		\dash\data::page_desc(T_('You can signup in some festival course'));

		\dash\data::badge_link(\dash\url::this(). '?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to my course list'));


	}

}
?>
