<?php
namespace content_mokeb\place\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit place"));
		\dash\data::page_desc(T_('Edit name or description of this place or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to list of Places'));

		$id     = \dash\request::get('id');
		$result = \lib\app\place::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid place id"));
		}

		\dash\data::dataRow($result);

	}
}
?>