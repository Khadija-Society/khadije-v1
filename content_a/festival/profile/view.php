<?php
namespace content_a\festival\profile;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new festival request"). ' | '. T_('Step 2'));
		\dash\data::page_desc(T_('fill your personal data in this step'). ' '. T_('In next step fill your partner data'));

		\dash\data::userdetail(\dash\db\users::get(['id' => \dash\user::id(), 'limit' => 1]));

		$complete_profile = \dash\data::userdetail_iscompleteprofile();
		if(intval($complete_profile) === 1)
		{
			\dash\redirect::to(\dash\url::this(). '/request?'. http_build_query(\dash\request::get()));
		}

		\content_a\profile\view::static_var();
	}
}
?>
