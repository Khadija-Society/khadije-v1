<?php
namespace content_a\protection\occasion;


class controller
{
	public static function routing()
	{
		\content_a\protection\main::check();

		$id = \dash\request::get('id');
		$load = \lib\app\occasion::get($id);
		if(!$load)
		{
			\dash\header::status(404);
		}

		\dash\data::occasionDetail($load);

		$person = \dash\request::get('person');
		if($person)
		{
			$load_detail = \lib\app\protectagentuser::get(['occation_id' => $id, 'protectagentuser_id' => $person]);
			if(!$load_detail)
			{
				\dash\header::status(404);
			}
			\dash\data::editMode(true);
			\dash\data::dataRow($load_detail);
		}
	}
}
?>