<?php
namespace content_lottery\item\required;


class view
{
	public static function config()
	{
		\dash\data::page_title("Edit lottery required field");
		\dash\data::page_desc(T_('Edit name or description of this item or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));

		$id     = \dash\request::get('id');
		$result = \lib\app\syslottery::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid item id"));
		}

		\dash\data::dataRow($result);
		if(isset($result['requiredfield']))
		{
			\dash\data::requiredfield(json_decode($result['requiredfield'], true));
		}

	}
}
?>