<?php
namespace content_agent\servant\send;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantProfileView');
		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('tools');

		\dash\data::listSkills(\lib\app\skills::list(null, ['pagenation' => false]));

		$userid = \dash\coding::decode(\dash\request::get('user'));
		if($userid)
		{
			\dash\data::userSkills(\lib\db\userskills::get_user_skills($userid));
		}
	}
}
?>