<?php
namespace content_cp\nationalcode\edit;


class view
{
	public static function config()
	{
		\dash\permission::access('cpNationalCodeEdit');

		\dash\data::page_pictogram('edit');

		\dash\data::page_title(T_("Edit national code"));
		\dash\data::page_desc(T_("Edit special national code and update number of times"));
		\dash\data::badge_link(\dash\url::here(). '/nationalcode');
		\dash\data::badge_text(T_('Back to national codes list'));
		\dash\data::body_class('unselectable siftal');

		if(\dash\request::get('id') && is_numeric(\dash\request::get('id')))
		{
			\dash\data::nationalcodeDetail(\lib\db\nationalcodes::get(['id' => \dash\request::get('id'), 'limit' => 1]));
		}
	}
}
?>
