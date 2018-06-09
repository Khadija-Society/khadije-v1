<?php
namespace content_cp\donate\options;


class view
{
	public static function config()
	{
		\dash\permission::access('cpDonateOption');

		\dash\data::page_pictogram('cogs');

		\dash\data::page_title(T_("Donation options"));
		\dash\data::page_desc(T_("check and update some options on donations"));
		\dash\data::badge_link(\dash\url::here(). '/donate');
		\dash\data::badge_text(T_('Back to donate list'));
		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		\dash\data::need(\lib\app\need::list('donate'));

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
