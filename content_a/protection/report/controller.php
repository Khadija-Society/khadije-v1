<?php
namespace content_a\protection\report;


class controller
{
	public static function routing()
	{
		\content_a\protection\main::check();

		$id = \dash\request::get('id');
		$load = \lib\app\protectionagentoccasion::get($id);
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