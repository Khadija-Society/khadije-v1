<?php
namespace content_agent\servant\add;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Add new servant"));

		\dash\data::page_pictogram('plus-circle');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back to list of servants'));
	}
}
?>