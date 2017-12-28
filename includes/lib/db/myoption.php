<?php
namespace lib\db;

class myoption
{

	public static function check_city_place_duplicate($_city, $_place, $_cat)
	{
		$query = "SELECT * FROM options WHERE options.cat = '$_cat' AND options.value = '$_city' AND options.meta = '$_place' LIMIT 1";
		return \lib\db::get($query, null, true);
	}

	public static function remove($_id)
	{
		$query = "DELETE FROM options WHERE options.id = '$_id' LIMIT 1";
		return \lib\db::query($query);
	}
}
?>
