<?php
namespace content_smsapp\platoon;


class controller
{
	public static function routing()
	{
		\dash\permission::access('smsAppSetting');


		// if(\dash\request::get('copy') === 'fix')
		// {
		// 	$get_list = \dash\db::get("SELECT * FROM s_group WHERE s_group.platoon = 1");

		// 	foreach ($get_list as $key => $value)
		// 	{
		// 		$get_filter = \dash\db::get("SELECT * FROM s_groupfilter WHERE s_groupfilter.group_id = $value[id]");

		// 		$new_group =
		// 		[
		// 			'title'        => a($value, 'title'),
		// 			'type'         => a($value, 'type'),
		// 			'status'       => a($value, 'status'),
		// 			'analyze'      => intval(a($value, 'analyze')),
		// 			'ismoney'      => intval(a($value, 'ismoney')),
		// 			'count'        => a($value, 'count'),
		// 			'answer'       => a($value, 'answer'),
		// 			'creator'      => a($value, 'creator'),
		// 			'datecreated'  => a($value, 'datecreated'),
		// 			'datemodified' => a($value, 'datemodified'),
		// 			'sort'         => a($value, 'sort'),
		// 			'calcdate'     => a($value, 'calcdate'),
		// 			'platoon'      => 4,
		// 		];

		// 		$new_group_id = \lib\db\smsgroup::insert($new_group);


		// 		foreach ($get_filter as $k => $v)
		// 		{

		// 			$new_filter =
		// 			[
		// 				'type'           => a($v, 'type'),
		// 				'number'         => a($v, 'number'),
		// 				'group_id'       => $new_group_id,
		// 				'text'           => a($v, 'text'),
		// 				'exactly'        => a($v, 'exactly'),
		// 				'contain'        => a($v, 'contain'),
		// 				'isdefault'      => intval(a($v, 'isdefault')),
		// 				'isdefaultpanel' => intval(a($v, 'isdefaultpanel')),
		// 				'sort'           => a($v, 'sort'),

		// 			];

		// 			\lib\db\smsgroupfilter::insert($new_filter);


		// 		}


		// 	}
		// 	var_dump($get_list);exit;
		// 	var_dump(11);exit();
		// }


	}
}
?>
