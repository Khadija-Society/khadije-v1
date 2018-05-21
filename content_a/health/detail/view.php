<?php
namespace content_a\health\detail;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new health request"). ' | '. T_('Step 3'));
		\dash\data::page_desc(T_('fill your request detail'));

		\dash\data::editMode(true);

		$id = \dash\request::get('id');

		if(is_numeric($id))
		{
			\dash\data::serviceDetail(\lib\db\services::get(['id' => $id, 'user_id' => \dash\user::id(), 'limit' => 1]));
		}

		if(!\dash\data::serviceDetail())
		{
			\dash\header::status(404, T_("Id not found"));
		}
	}

}
?>
