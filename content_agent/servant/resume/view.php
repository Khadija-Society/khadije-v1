<?php
namespace content_agent\servant\resume;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantProfileView');
		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('magic');

		$userid = \dash\coding::decode(\dash\request::get('user'));
		if($userid)
		{
			\dash\data::dataTable(\lib\app\resume::list(null,['user_id' => $userid, 'pagenation' => false]));
		}

	}
}
?>