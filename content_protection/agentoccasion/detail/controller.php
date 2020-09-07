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

		\dash\data::dataRow($load);

		if(isset($load['protection_occasion_id']))
		{
			\dash\data::occasionID($load['protection_occasion_id']);
			\dash\data::occasionDetail(\lib\app\occasion::get($load['protection_occasion_id']));
		}

	}
}
?>