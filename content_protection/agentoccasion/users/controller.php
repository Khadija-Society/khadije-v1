<?php
namespace content_protection\agentoccasion\users;


class controller
{
	public static function routing()
	{


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
			$person = \dash\request::get('person');
			if($person)
			{
				$load_detail = \lib\app\protectagentuser::admin_get(['occation_id' => $load['protection_occasion_id'], 'protectagentuser_id' => $person]);
				if(!$load_detail)
				{
					\dash\header::status(404);
				}
				\dash\data::editMode(true);
				\dash\data::personDataRow($load_detail);
			}
		}

	}
}
?>