<?php
namespace content_agent\send\view;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title("نمایش جزئیات اعزام");

		\dash\data::page_pictogram('paper-plane');

		\content_agent\send\billing\view::tempText();

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back'));


	}
}
?>