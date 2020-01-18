<?php
namespace content_agent\send\assessment;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantProfileView');
		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('magic');



	}
}
?>