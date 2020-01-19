<?php
namespace content_agent\skills\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit skills"));
		\dash\data::page_desc(' ');
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back to list of skillss'));

		$id     = \dash\request::get('id');
		$result = \lib\app\skills::get($id);
		if(!$result)
		{
			\dash\header::status(403, T_("Invalid skills id"));
		}

		\dash\data::dataRow($result);


	}
}
?>