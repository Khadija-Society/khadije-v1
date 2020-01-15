<?php
namespace lib\app;

/**
 * Class for assessmentitem.
 */
class assessmentitem
{

	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("assessmentitem id not set"));
			return false;
		}

		$get = \lib\db\assessmentitem::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid assessmentitem id"));
			return false;
		}

		$result = self::ready($get);

		return $result;
	}


	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_id = null)
	{
		$title = \dash\app::request('title');
		$title = trim($title);
		if(!$title)
		{
			\dash\notif::error(T_("Please fill the assessmentitem title"), 'title');
			return false;
		}

		if(mb_strlen($title) > 150)
		{
			\dash\notif::error(T_("Please fill the assessmentitem title less than 150 character"), 'title');
			return false;
		}

		$check_duplicate = \lib\db\assessmentitem::get(['title' => $title, 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				\dash\notif::error(T_("Duplicate assessmentitem title"), 'title');
				return false;
			}
		}



		$city = \dash\app::request('city');
		if($city && !in_array($city, ['qom', 'mashhad', 'karbala']))
		{
			\dash\notif::error(T_("Invalid city"));
			return false;
		}


		$job = \dash\app::request('job');
		if($job && !in_array($job, ['clergy', 'adminoffice', 'admin', 'missionary', 'servant']))
		{
			\dash\notif::error(T_("Invalid job"));
			return false;
		}


		$status = \dash\app::request('status');
		if($status && !in_array($status, ['enable', 'disable']))
		{
			\dash\notif::error(T_("Invalid status of assessmentitem"), 'status');
			return false;
		}

		$sort = \dash\app::request('sort');
		if($sort && !is_numeric($sort))
		{
			\dash\notif::error(T_("Please set sort as a number"), 'sort');
			return false;
		}

		if($sort)
		{
			$sort = abs(intval($sort));
		}

		if($sort && $sort > 9999)
		{
			\dash\notif::error(T_("Sort is out of range"), 'sort');
			return false;
		}


		$rate = \dash\app::request('rate');
		if($rate && !is_numeric($rate))
		{
			\dash\notif::error(T_("Please set rate as a number"), 'rate');
			return false;
		}

		if($rate)
		{
			$rate = abs(intval($rate));
		}

		if($rate && $rate > 9999)
		{
			\dash\notif::error(T_("Sort is out of range"), 'rate');
			return false;
		}





		$args               = [];
		$args['title']      = $title;
		$args['job']    = $job;
		$args['city']       = $city;
		$args['status']     = $status;
		$args['sort']       = $sort;
		$args['rate']       = $rate;

		return $args;
	}


	/**
	 * add new assessmentitem
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args = [])
	{
		\dash\app::variable($_args);

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("user not found"), 'user');
			return false;
		}


		// check args
		$args = self::check();

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		$return = [];

		if(!$args['status'])
		{
			$args['status']  = 'enable';
		}

		$assessmentitem_id = \lib\db\assessmentitem::insert($args);

		if(!$assessmentitem_id)
		{
			\dash\log::set('apiAssessmentitem:no:way:to:insertAssessmentitem');
			\dash\notif::error(T_("No way to insert assessmentitem"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($assessmentitem_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewAssessmentitem', ['code' => $assessmentitem_id]);
			\dash\notif::ok(T_("Assessmentitem successfuly added"));
		}

		return $return;
	}


	public static $sort_field =
	[
		'title',
		'rate',
		'city',
		'sort',
		'status',
		'job',
	];


	/**
	 * Gets the assessmentitem.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The assessmentitem.
	 */
	public static function list($_string = null, $_args = [])
	{
		// if(!\dash\user::id())
		// {
		// 	return false;
		// }

		$default_meta =
		[
			'sort'  => null,
			'order' => null,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_meta, $_args);

		if($_args['sort'] && !in_array($_args['sort'], self::$sort_field))
		{
			$_args['sort'] = null;
		}

		$result            = \lib\db\assessmentitem::search($_string, $_args);
		$temp              = [];

		foreach ($result as $key => $value)
		{
			$check = self::ready($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		return $temp;
	}


	/**
	 * edit a assessmentitem
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function edit($_args, $_id)
	{
		\dash\app::variable($_args);

		$result = self::get($_id);

		if(!$result)
		{
			return false;
		}

		$id = \dash\coding::decode($_id);

		$args = self::check($id);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}


		if(!\dash\app::isset_request('title')) unset($args['title']);
		if(!\dash\app::isset_request('rate')) unset($args['rate']);

		if(!\dash\app::isset_request('job')) unset($args['job']);

		if(!\dash\app::isset_request('city')) unset($args['city']);
		if(!\dash\app::isset_request('sort')) unset($args['sort']);
		if(!\dash\app::isset_request('status')) unset($args['status']);


		if(!empty($args))
		{
			$update = \lib\db\assessmentitem::update($args, $id);
			\dash\log::set('editAssessmentitem', ['code' => $id]);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
		}
	}

	/**
	 * ready data of assessmentitem to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready($_data)
	{
		$result = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
					$result[$key] = \dash\coding::encode($value);
					break;

				case 'perm':
					if(is_string($value))
					{
						$result['perm'] = json_decode($value, true);
						if(is_array($result['perm']))
						{
							$result['perm'] = array_map(['\\dash\\coding', 'encode'], $result['perm']);
						}
					}
					else
					{
						$result[$key] = $value;
					}
					break;


				case 'file':
					if(!\dash\url::content())
					{
						if(!$value)
						{
							$value = \dash\app::static_logo_url();
						}
					}
					$result[$key] = $value;
					$result[$key] = $value;
					break;


				default:
					$result[$key] = $value;
					break;
			}
		}

		return $result;
	}

}
?>