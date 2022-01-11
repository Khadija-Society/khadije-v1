<?php
namespace content_protection\agentoccasion\access;


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


		if(\dash\request::get('cid'))
		{
			$childDataRow = \lib\app\protectionagentoccasionchild::get_by_id(\dash\request::get('cid'));
			if(!$childDataRow)
			{
				\dash\header::status(404);
			}
			\dash\data::editMode(true);
			\dash\data::childDataRow($childDataRow);
		}

	}
}
?>