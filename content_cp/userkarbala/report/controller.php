<?php
namespace content_cp\userkarbala\report;


class controller
{
	public static function routing()
	{
		self::qom('IR-13');
		\dash\permission::access('cpUsersKarbalaView');

		$subchild = \dash\url::subchild();
		if(in_array($subchild, ['provincelist', 'map']))
		{
			\dash\open::get();
		}

	}

	public static function qom($_code)
	{
		$query = "SELECT COUNT(*) AS `count` FROM karbalausers WHERE karbalausers.province = '$_code' ";
		$count = \dash\db::get($query, 'count', true);
		$count = floor($count / 40);

		$id = [];
		for ($i=1; $i <= 40 ; $i++) 
		{ 
			$start = $i * $count;
			$id[] = \dash\db::get("SELECT karbalausers.id AS `id` FROM karbalausers WHERE karbalausers.province = '$_code' LIMIT $start, 1", 'id', true);
		}
		$id = implode(',', $id);
		$result = \dash\db::get("SELECT * FROM karbalausers WHERE id in ($id)");
		\dash\utility\export::csv(['data' => $result]);
		
	}
}
?>
