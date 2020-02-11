<?php
namespace content_agent\servant\skills;


class view
{
	public static function config()
	{

		\dash\data::page_title("تخصص‌های خادم");

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back to list of servants'));

		\dash\data::page_pictogram('tools');

		\dash\data::listSkills(\lib\app\skills::list(null, ['status' => 'enable', 'pagenation' => false]));

		$userid = \dash\coding::decode(\dash\request::get('user'));
		if($userid)
		{
			\dash\data::userSkills(\lib\db\userskills::get_user_skills($userid));
		}
	}
}
?>