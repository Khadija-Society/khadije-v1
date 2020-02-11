<?php
namespace content_agent\servant\profile;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('user');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back to list of servants'));

	}
}
?>