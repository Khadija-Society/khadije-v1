<?php
namespace content_a\protection\child;


class controller
{
	public static function routing()
	{
		\content_a\protection\main::check();

		$id = \dash\request::get('id');
		$load = \lib\app\protectionagentoccasion::get_as_child($id);
		if(!$load)
		{
			\dash\header::status(404);
		}

		\dash\data::dataRow($load);

		if(isset($load['protection_occasion_id']))
		{
			\dash\data::occasionID($load['protection_occasion_id']);
			\dash\data::occasionDetail(\lib\app\occasion::get($load['protection_occasion_id']));

			if(\dash\data::occasionDetail_status() === 'deleted')
			{
				\dash\header::status(404);
			}
			$person = \dash\request::get('person');
			if($person)
			{
				$load_detail = \lib\app\protectagentuser::get(['occation_id' => $load['protection_occasion_id'], 'protectagentuser_id' => $person]);
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