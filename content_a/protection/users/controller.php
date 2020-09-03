<?php
namespace content_a\protection\users;


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

		if(isset($load['protection_occasion_id']))
		{
			\dash\data::occasionID($load['protection_occasion_id']);
			\dash\data::occasionDetail(\lib\app\occasion::get($load['protection_occasion_id']));
			$person = \dash\request::get('person');
			if($person)
			{
				$load_detail = \lib\app\protectagentuser::get(['occation_id' => $load['protection_occasion_id'], 'protectagentuser_id' => $person]);
				if(!$load_detail)
				{
					\dash\header::status(404);
				}
				\dash\data::editMode(true);
				\dash\data::dataRow($load_detail);
			}
		}

	}
}
?>