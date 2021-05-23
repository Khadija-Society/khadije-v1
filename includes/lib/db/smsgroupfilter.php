<?php
namespace lib\db;


class smsgroupfilter
{

	public static function check_duplicate_answer($_answer)
	{
		$query  =
		"
			SELECT
				s_groupfilter.*
			FROM
				s_groupfilter
			LEFT JOIN s_group ON s_groupfilter.group_id = s_group.id
			WHERE
				s_group.status != 'deleted' AND
				s_groupfilter.type = 'analyze'  AND
				s_groupfilter.text = '$_answer'
			LIMIT 1
		";
		$result = \dash\db::get($query, null, true);

		return $result;
	}

	public static function list_analyze_word()
	{
		$query  =
		"
			SELECT
				s_groupfilter.text,
				s_groupfilter.group_id
			FROM
				s_groupfilter
			INNER JOIN s_group ON s_group.id = s_groupfilter.group_id
			WHERE
				s_group.status     = 'enable' AND
				s_group.type       = 'other' AND
				s_groupfilter.type = 'analyze'
			ORDER BY s_group.sort ASC, s_groupfilter.id ASC
		";

		$result = \dash\db::get($query);
		return $result;
	}

	public static function have_old_record_filter($_group_id)
	{
		$query  =
		"
			SELECT
				s_sms.id
			FROM
				s_sms
			WHERE
				s_sms.group_id IS NULL AND
				s_sms.fromnumber IN (SELECT s_groupfilter.number FROM s_groupfilter WHERE s_groupfilter.group_id = $_group_id)
		";
		$result = \dash\db::get($query, 'id');

		return $result;
	}

	public static function update_old_record_filter($_id, $_group_id)
	{
		$query  =
		"
			UPDATE
				s_sms
			SET
				s_sms.group_id      = $_group_id,
				s_sms.receivestatus = 'block',
				s_sms.recommend_id  = NULL
			WHERE
				s_sms.id IN ($_id)
		";

		$result = \dash\db::query($query);
		return $result;
	}

	public static function update_old_record_filter_recommend($_id, $_group_id)
	{
		$query  =
		"
			UPDATE
				s_sms
			SET
				s_sms.recommend_id = $_group_id
			WHERE
				s_sms.id IN ($_id)
		";

		$result = \dash\db::query($query);
		return $result;
	}


	public static function not_in_another($_text, $_group_id)
	{
		$query  =
		"
			SELECT
				*
			FROM
				s_groupfilter
			WHERE
				s_groupfilter.type = 'analyze' AND
				s_groupfilter.group_id != $_group_id AND
				s_groupfilter.text IN $_text
			LIMIT 1
		";
		$result = \dash\db::get($query, null, true);
		return $result;
	}


	public static function multi_remove_analyze($_analye, $_group_id)
	{
		$query  = "DELETE FROM s_groupfilter  WHERE s_groupfilter.type = 'analyze' AND s_groupfilter.group_id = $_group_id AND s_groupfilter.text IN ('$_analye') ";
		\dash\db::query($query);
		return;
	}

	public static function remove_all_default($_type, $_group_id, $_panel = null)
	{
		if($_panel)
		{
			$query  = "UPDATE s_groupfilter SET s_groupfilter.isdefaultpanel = NULL WHERE s_groupfilter.type = '$_type' AND s_groupfilter.group_id = $_group_id ";
		}
		else
		{
			$query  = "UPDATE s_groupfilter SET s_groupfilter.isdefault = NULL WHERE s_groupfilter.type = '$_type' AND s_groupfilter.group_id = $_group_id ";
		}
		$result = \dash\db::query($query);
		return $result;
	}


	public static function set_default($_id, $_panel = null)
	{
		if($_panel)
		{
			$query  = "UPDATE s_groupfilter SET s_groupfilter.isdefaultpanel = 1 WHERE s_groupfilter.id = $_id LIMIT 1 ";
		}
		else
		{
			$query  = "UPDATE s_groupfilter SET s_groupfilter.isdefault = 1 WHERE s_groupfilter.id = $_id LIMIT 1 ";
		}
		$result = \dash\db::query($query);
		return $result;
	}


	public static function insert()
	{
		\dash\db\config::public_insert('s_groupfilter', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('s_groupfilter', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('s_groupfilter', ...func_get_args());
	}


	public static function get()
	{
		return \dash\db\config::public_get('s_groupfilter', ...func_get_args());
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('s_groupfilter', ...func_get_args());
	}

	public static function delete($_id)
	{
		return \dash\db::query("DELETE FROM s_groupfilter WHERE s_groupfilter.id = $_id LIMIT 1");
	}


	public static function search()
	{
		$result = \dash\db\config::public_search('s_groupfilter', ...func_get_args());
		return $result;
	}

}
?>
