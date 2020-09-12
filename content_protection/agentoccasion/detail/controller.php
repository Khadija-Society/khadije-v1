<?php
namespace content_protection\agentoccasion\detail;


class controller
{
	public static function routing()
	{
		\dash\permission::access('protectonUserAdmin');

		$id = \dash\request::get('id');
		$load = \lib\app\protectionagentoccasion::admin_get($id);
		if(!$load)
		{
			\dash\header::status(404);
		}

		if(isset($load['protection_agent_id']))
		{
			\dash\data::protectionAgentID($load['protection_agent_id']);
		}


		\dash\data::dataRow($load);

		if(isset($load['protection_occasion_id']))
		{
			\dash\data::occasionID($load['protection_occasion_id']);
			\dash\data::occasionDetail(\lib\app\occasion::get($load['protection_occasion_id']));
		}

	}
}
?>