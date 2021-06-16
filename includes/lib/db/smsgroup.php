<?php
namespace lib\db;


class smsgroup
{


	public static function get_answering_group($_platoon)
	{
		$query  = "SELECT DISTINCT s_group.* FROM s_group LEFT JOIN s_groupfilter ON s_groupfilter.group_id = s_group.id  WHERE s_group.status = 'enable' AND s_sms.platoon = '$_platoon' AND s_groupfilter.type = 'answer' AND s_group.type = 'other'   ";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function show_list($_platoon)
	{
		$query  =
		"
			SELECT
				s_group.*,
				(SELECT COUNT(*) FROM s_groupfilter WHERE s_groupfilter.group_id = s_group.id AND s_groupfilter.type = 'analyze') AS `count_tag`,
				(SELECT COUNT(*) FROM s_groupfilter WHERE s_groupfilter.group_id = s_group.id AND s_groupfilter.type = 'answer') AS `count_answer`
			FROM
				s_group
			WHERE
				s_group.status IN ('enable', 'disable') AND
				s_group.platoon = '$_platoon' AND
				s_group.type = 'other'
			ORDER BY s_group.sort ASC
		";
		$result = \dash\db::get($query);
		return $result;
	}




	public static function insert()
	{
		\dash\db\config::public_insert('s_group', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('s_group', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('s_group', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('s_group', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('s_group', ...func_get_args());
	}

	public static function search($_string = null, $_option = [])
	{
		$default =
		[
			'search_field' => "(s_group.title LIKE '%__string__%')",
			'public_show_field' =>
			"
				s_group.*,
				(SELECT GROUP_CONCAT(s_groupfilter.number) FROM s_groupfilter WHERE s_groupfilter.group_id = s_group.id AND s_groupfilter.type = 'number') AS `number`,
				(SELECT GROUP_CONCAT(s_groupfilter.text) FROM s_groupfilter WHERE s_groupfilter.group_id = s_group.id AND s_groupfilter.type = 'analyze') AS `analyze`,
				(SELECT GROUP_CONCAT(s_groupfilter.text) FROM s_groupfilter WHERE s_groupfilter.group_id = s_group.id AND s_groupfilter.type = 'answer') AS `answer`

			",
			"master_join" => "",
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default, $_option);
		$result = \dash\db\config::public_search('s_group', $_string, $_option);
		return $result;
	}


	public static function remvoe_all_filter($_id)
	{
		$query =
		"
			UPDATE
				s_sms
			SET
				s_sms.group_id = NULL
			WHERE s_sms.group_id = $_id
		";

		\dash\db::query($query);
		$query = "UPDATE s_sms SET s_sms.recommend_id = NULL WHERE s_sms.recommend_id = $_id ";
		\dash\db::query($query);
		$query = "DELETE FROM s_groupfilter WHERE s_groupfilter.group_id = $_id ";
		\dash\db::query($query);
	}


	public static function delete($_id)
	{
		$query = "DELETE FROM s_group WHERE s_group.id = $_id LIMIT 1";
		return \dash\db::query($query);
	}



}
?>
