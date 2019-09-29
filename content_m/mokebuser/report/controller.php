<?php
namespace content_m\mokebuser\report;


class controller
{
	public static function routing()
	{

		\dash\permission::access('cpUsersKarbalaView');

		$subchild = \dash\url::subchild();
		if(in_array($subchild, ['provincelist', 'map']))
		{
			\dash\open::get();
		}

	}

	public static function qom($_code)
	{
		$query = "SELECT COUNT(*) AS `count` FROM mokebusers WHERE mokebusers.province = '$_code' ";
		$count = \dash\db::get($query, 'count', true);
		$count = floor($count / 40);

		$id = [];
		for ($i=1; $i <= 40 ; $i++)
		{
			$start = $i * $count;
			$id[] = \dash\db::get("SELECT mokebusers.id AS `id` FROM mokebusers WHERE mokebusers.province = '$_code' LIMIT $start, 1", 'id', true);
		}
		$id = implode(',', $id);
		$result = \dash\db::get("SELECT * FROM mokebusers WHERE id in ($id)");
		\dash\utility\export::csv(['data' => $result]);

	}
}
?>
