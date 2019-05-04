<?php
namespace content_m\options\product;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Khadije Dashboard"));

		\dash\data::page_special(true);

		\dash\data::badge_link(\dash\url::here(). '/options/product');
		\dash\data::badge_text(T_('Add new need'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		\dash\data::need(\lib\app\need::list('product'));

		if(\dash\request::get('edit'))
		{
			\dash\data::editMode(true);
			$id = \dash\request::get('edit');
			\dash\data::productDetail(\lib\db\needs::get(['id' => $id, 'limit' => 1]));
			if(!\dash\data::productDetail())
			{
				\dash\header::status(404, T_("Id not found"));
			}
		}
	}
}
?>
