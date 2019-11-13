<?php
namespace content_m\userkarbala2\report;


class controller
{
	public static function routing()
	{

		\dash\permission::access('koyeMohebbat');

		$subchild = \dash\url::subchild();
		if(in_array($subchild, ['provincelist', 'map']))
		{
			\dash\open::get();
		}

	}

	public static function qom($_code)
	{
		$query = "SELECT COUNT(*) AS `count` FROM karbala2users WHERE karbala2users.province = '$_code' ";
		$count = \dash\db::get($query, 'count', true);
		$count = floor($count / 40);

		$id = [];
		for ($i=1; $i <= 40 ; $i++)
		{
			$start = $i * $count;
			$id[] = \dash\db::get("SELECT karbala2users.id AS `id` FROM karbala2users WHERE karbala2users.province = '$_code' LIMIT $start, 1", 'id', true);
		}
		$id = implode(',', $id);
		$result = \dash\db::get("SELECT * FROM karbala2users WHERE id in ($id)");
		\dash\utility\export::csv(['data' => $result]);

	}
}
?>
