<?php
namespace content_m\product\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit product"));
		\dash\data::page_desc(T_('Edit name or description of this product or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to list of Products'));

		$id     = \dash\request::get('id');
		$result = \lib\app\product::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid product id"));
		}

		\dash\data::dataRow($result);

	}
}
?>