<?php
namespace content_lottery\item\add;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Add new lottery"));
		\dash\data::page_pictogram('plus-circle');
		\dash\data::badge_link(\dash\url::this(). \dash\data::xTypeStart());
		\dash\data::badge_text(T_('Back'));
	}
}
?>