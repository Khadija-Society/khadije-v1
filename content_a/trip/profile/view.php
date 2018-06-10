<?php
namespace content_a\trip\profile;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new trip request"). ' | '. T_('Step 2'));
		\dash\data::page_desc(T_('fill your personal data in this step'). ' '. T_('In next step fill your partner data'));


		\dash\data::userdetail(\dash\db\users::get(['id' => \dash\user::id(), 'limit' => 1]));
		\content_a\profile\view::static_var();
	}
}
?>
