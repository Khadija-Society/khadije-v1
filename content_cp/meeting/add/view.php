<?php
namespace content_cp\meeting\add;


class view
{
	public static function config()
	{
		\dash\permission::access('cpMeetingAdd');

		\dash\data::page_pictogram('plus-circle');

		\dash\data::page_title(T_("Add new meeting report"));
		\dash\data::page_desc(T_("Fill the field below and add new meeting report"));
		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to meeting report list'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		if(\dash\request::get('id'))
		{
			$id = \dash\coding::decode(\dash\request::get('id'));

			if(!$id)
			{
				\dash\header::status(404, T_("Invalid id"));
			}

			$load = \dash\db\posts::get(['id' => $id, 'limit' => 1]);

			if(!isset($load['user_id']))
			{
				\dash\header::status(404, T_("Id not found"));
			}

			\dash\data::dataRow($load);

		}
	}

}
?>
