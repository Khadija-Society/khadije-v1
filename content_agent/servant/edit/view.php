<?php
namespace content_agent\servant\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit servant"));
		\dash\data::page_desc(' ');
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back to list of servants'));

		$id     = \dash\request::get('sid');
		$result = \lib\app\servant::get($id);
		if(!$result)
		{
			\dash\header::status(403, T_("Invalid servant id"));
		}

		\dash\data::dataRow($result);


	}
}
?>