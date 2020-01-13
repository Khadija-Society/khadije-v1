<?php
namespace content_agent\assessmentitem\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit assessmentitem"));
		\dash\data::page_desc(T_('Edit name or description of this assessmentitem or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to list of Assessmentitems'));

		$id     = \dash\request::get('id');
		$result = \lib\app\assessmentitem::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid assessmentitem id"));
		}

		\dash\data::dataRow($result);


	}
}
?>