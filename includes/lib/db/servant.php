<?php
namespace lib\db;


class servant
{

	public static function insert()
	{
		\dash\db\config::public_insert('agent_servant', ...func_get_args());
		return \dash\db::insert_id();
	}


	public static function multi_insert()
	{
		return \dash\db\config::public_multi_insert('agent_servant', ...func_get_args());
	}


	public static function update()
	{
		return \dash\db\config::public_update('agent_servant', ...func_get_args());
	}


	public static function get($_args)
	{
		$options =
		[
			'public_show_field' => "agent_servant.*, IFNULL(users.displayname, CONCAT(users.firstname, ' ', users.lastname)) AS `displayname`, users.avatar, users.mobile",
			'master_join' => "INNER JOIN users ON users.id = agent_servant.user_id",
		];
		$result = \dash\db\config::public_get('agent_servant', $_args, $options);

		return $result;
	}

	public static function get_count()
	{
		return \dash\db\config::public_get_count('agent_servant', ...func_get_args());
	}


	public static function delete($_id)
	{
		$query  = "DELETE FROM agent_servant WHERE agent_servant.id = $_id LIMIT 1";
		$result = \dash\db::query($query);
		return $result;
	}


	public static function search($_string = null, $_args = [])
	{

		$default =
		[
			'sort_join'         => false,
			'public_show_field' => "agent_servant.*, IFNULL(users.displayname, CONCAT(users.firstname, ' ', users.lastname)) AS `displayname`, users.avatar, users.mobile",
			'master_join'       => "INNER JOIN users ON users.id = agent_servant.user_id",
			'search_field'      => " ( users.mobile LIKE '%__string__%' or users.displayname LIKE '%__string__%' ) ",
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default, $_args);

		if($_args['sort_join'])
		{
			$_args['public_show_field'] =
			"
				agent_servant.*,
				IFNULL(users.displayname, CONCAT(users.firstname, ' ', users.lastname)) AS `displayname`, users.avatar, users.mobile,
				(SELECT COUNT(*) FROM agent_send WHERE agent_send.missionary_id = agent_servant.user_id) AS `send_count`,
				(SELECT AVG(agent_assessment.percent) FROM agent_send INNER JOIN agent_assessment ON agent_assessment.send_id = agent_send.id WHERE agent_send.missionary_id = agent_servant.user_id) AS `send_avg`,
				(SELECT MIN(agent_send.startdate) FROM agent_send WHERE agent_send.missionary_id = agent_servant.user_id) AS `min_startdate`,

				(
					SELECT
						GREATEST
						(
							(SELECT MAX(agent_send.startdate) FROM agent_send WHERE agent_send.missionary_id = agent_servant.user_id),
							agent_servant.reject_date
						)
				) AS `max_startdate`


			";
			$_args['master_join']       = "INNER JOIN users ON users.id = agent_servant.user_id";
			$_args['order_raw'] = ' `max_startdate` ASC';
		}

		unset($_args['sort_join']);
		$result = \dash\db\config::public_search('agent_servant', $_string, $_args);
		// j($result);
		return $result;
	}

}
?>
