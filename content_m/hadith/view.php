<?php
namespace content_m\hadith;


class view
{
	public static function config()
	{
		\dash\permission::access('cpHadith');

		\dash\data::page_pictogram('list');

		\dash\data::page_title(T_("Hadith list"));
		\dash\data::page_desc(T_("check hadith list and update it or add new!"));
		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		\dash\data::need(\lib\app\need::list('hadith'));

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
