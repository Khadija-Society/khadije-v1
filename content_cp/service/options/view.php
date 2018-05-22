<?php
namespace content_cp\service\options;


class view
{
	public static function config()
	{
		\dash\permission::access('cpServiceOption');

		\dash\data::page_title(T_("Service request options"));
		\dash\data::page_desc(T_("check service request options and update requests"));
		\dash\data::badge_link(\dash\url::here(). '/service');
		\dash\data::badge_text(T_('Back to service request list'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		\dash\data::need(\lib\app\need::list('expertise'));

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
