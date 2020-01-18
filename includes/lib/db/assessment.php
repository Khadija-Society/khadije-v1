<?php
namespace lib\db;

class assessment
{

	public static function get_avg_group($_send_id)
	{
		$query  =
		"
			SELECT
				COUNT(*) AS `count`,
				AVG(agent_assessment.percent) AS `avg`,
				SUM(agent_assessment.score) AS `score`,
				MAX(agent_assessment.job_for) AS `job`,
				agent_assessment.assessment_for,
				users.displayname,
				users.mobile,
				users.avatar

			FROM
				agent_assessment
			LEFT JOIN users ON users.id = agent_assessment.assessment_for
			WHERE
				agent_assessment.send_id = $_send_id
			GROUP BY agent_assessment.assessment_for
		";
		$result = \dash\db::get($query);
		return $result;
	}


	public static function get_list($_job, $_city)
	{
		$query  =
		"
			SELECT agent_assessmentitem.*
			FROM
				agent_assessmentitem
			WHERE
				( agent_assessmentitem.city IS NULL OR   agent_assessmentitem.city = '$_city' )
				AND
				( agent_assessmentitem.job IS NULL OR   agent_assessmentitem.job = '$_job' )
				AND
				agent_assessmentitem.status = 'enable'
		";
		$result = \dash\db::get($query);
		return $result;
	}

	/**
	 * insert new agent_assessmentprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function insert()
	{
		\dash\db\config::public_insert('agent_assessment', ...func_get_args());
		return \dash\db::insert_id();
	}


	/**
	 * update agent_assessmentprice
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function update()
	{
		return \dash\db\config::public_update('agent_assessment', ...func_get_args());
	}


	/**
	 * get agent_assessmentprice detail
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public static function get()
	{
		$result = \dash\db\config::public_get('agent_assessment', ...func_get_args());
		return $result;
	}


	public static function search($_string = null, $_options = [])
	{
		if(!is_array($_options))
		{
			$_options = [];
		}

		$default_option =
		[
			'search_field'      =>" (agent_assessment.title LIKE '%__string__%') ",
		];

		$_options = array_merge($default_option, $_options);
		return \dash\db\config::public_search('agent_assessment', $_string, $_options);
	}


}
?>