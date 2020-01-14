<?php
namespace lib\app;

/**
 * Class for send.
 */
class send
{

	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("send id not set"));
			return false;
		}

		$get = \lib\db\send::get(['agent_send.id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid send id"));
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


		$user_id        = \dash\app::request('user_id');
		if(\dash\app::isset_request('user_id'))
		{

			if(!$user_id)
			{
				\dash\notif::error(T_("Please select member"), 'member');
				return false;
			}

			$user_id = \dash\coding::decode($user_id);
			if(!$user_id)
			{
				\dash\notif::error(T_("Invalid user id"), 'member');
				return false;
			}

			$check_user = \dash\db\users::get_by_id($user_id);
			if(!isset($check_user['id']))
			{
				\dash\notif::error(T_("Member not found"), 'member');
				return false;
			}
		}


		$place_id       = \dash\app::request('place_id');
		if(\dash\app::isset_request('place_id'))
		{

			$place_id = \dash\coding::decode($place_id);
			if(!$place_id)
			{
				\dash\notif::error(T_("Invalid place id"), 'palce');
				return false;
			}

			$check_place = \lib\db\agentplace::get(['id' => $place_id, 'limit' => 1]);
			if(!isset($check_place['id']))
			{
				\dash\notif::error(T_("Place not found"), 'member');
				return false;
			}
		}


		$city = \dash\app::request('city');
		if(\dash\app::isset_request('city'))
		{
			if(!$city)
			{
				\dash\notif::error(T_("Please choose city"), 'city');
				return false;
			}

			if($city && !in_array($city, ['qom', 'mashhad', 'karbala']))
			{
				\dash\notif::error(T_("Invalid city"));
				return false;
			}
		}


		$job = \dash\app::request('job');
		if(\dash\app::isset_request('job'))
		{
			if(!$job)
			{
				\dash\notif::error(T_("Please choose job"), 'job');
				return false;
			}

			if($job && !in_array($job, ['clergy', 'admin', 'missionary', 'servant']))
			{
				\dash\notif::error(T_("Invalid job"));
				return false;
			}
		}


		if($user_id || $city || $job)
		{

			$check_access = \lib\db\servant::get(['agent_servant.user_id' => $user_id, 'agent_servant.city' => $city, 'agent_servant.job' => $job, 'limit' => 1]);
			if(isset($check_access['id']))
			{
				// no problem to send it
			}
			else
			{
				$msg = T_("It is not possible to send this user to this city");
				\dash\notif::error($msg, 'member');
				return false;
			}
		}



		$startdate      = \dash\app::request('startdate');
		$startdate                 = \dash\utility\convert::to_en_number($startdate);
		if(\dash\utility\jdate::is_jalali($startdate))
		{
			$startdate = \dash\utility\jdate::to_gregorian($startdate);
		}

		if(!$startdate)
		{
			\dash\notif::error(T_("Start date is required"), 'startdate');
			return false;
		}


		$enddate        = \dash\app::request('enddate');
		$enddate                 = \dash\utility\convert::to_en_number($enddate);
		if(\dash\utility\jdate::is_jalali($enddate))
		{
			$enddate = \dash\utility\jdate::to_gregorian($enddate);
		}

		if(!$enddate)
		{
			\dash\notif::error(T_("End date is required"), 'enddate');
			return false;
		}

		if($startdate && $enddate)
		{
			if(intval(strtotime($startdate)) > intval(strtotime($enddate)))
			{
				\dash\notif::error(T_("Start date must before end date"), ['element' => ['startdate', 'enddate']]);
				return false;
			}
		}


		$assessmentdate = \dash\app::request('assessmentdate');
		$assessmentor   = \dash\app::request('assessmentor');
		$assessmentdesc = \dash\app::request('assessmentdesc');

		$score          = \dash\app::request('score');

		$paydate        = \dash\app::request('paydate');
		$payamount      = \dash\app::request('payamount');
		$paybank        = \dash\app::request('paybank');
		$paytype        = \dash\app::request('paytype');
		$paynumber      = \dash\app::request('paynumber');

		$gift           = \dash\app::request('gift');
		$desc           = \dash\app::request('desc');




		$args                   = [];

		$args['user_id']        = $user_id;
		$args['place_id']       = $place_id;
		$args['city']           = $city;
		$args['job']            = $job;
		$args['startdate']      = $startdate;
		$args['enddate']        = $enddate;
		$args['assessmentdate'] = $assessmentdate;
		$args['assessmentor']   = $assessmentor;
		$args['assessmentdesc'] = $assessmentdesc;
		$args['score']          = $score;
		$args['paydate']        = $paydate;
		$args['payamount']      = $payamount;
		$args['paybank']        = $paybank;
		$args['paytype']        = $paytype;
		$args['paynumber']      = $paynumber;
		$args['gift']           = $gift;
		$args['desc']           = $desc;


		return $args;
	}


	/**
	 * add new send
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

		$args['creator'] = \dash\user::id();

		$send_id = \lib\db\send::insert($args);

		if(!$send_id)
		{
			\dash\log::set('apiSend:no:way:to:insertSend');
			\dash\notif::error(T_("No way to insert send"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($send_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewSend', ['code' => $send_id]);
			\dash\notif::ok(T_("Send successfuly added"));
		}

		return $return;
	}


	public static $sort_field =
	[
		'user_id',
		'place_id',
		'city',
		'job',
		'startdate',
		'enddate',
		'assessmentdate',
		'assessmentor',
		'assessmentdesc',
		'score',
		'paydate',
		'payamount',
		'paybank',
		'paytype',
		'paynumber',
		'gift',
		'desc',
	];



	/**
	 * Gets the send.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The send.
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

		$result            = \lib\db\send::search($_string, $_args);
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
	 * edit a send
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


		if(!\dash\app::isset_request('user_id')) unset($args['user_id']);
		if(!\dash\app::isset_request('place_id')) unset($args['place_id']);
		if(!\dash\app::isset_request('city')) unset($args['city']);
		if(!\dash\app::isset_request('job')) unset($args['job']);
		if(!\dash\app::isset_request('startdate')) unset($args['startdate']);
		if(!\dash\app::isset_request('enddate')) unset($args['enddate']);
		if(!\dash\app::isset_request('assessmentdate')) unset($args['assessmentdate']);
		if(!\dash\app::isset_request('assessmentor')) unset($args['assessmentor']);
		if(!\dash\app::isset_request('assessmentdesc')) unset($args['assessmentdesc']);
		if(!\dash\app::isset_request('score')) unset($args['score']);
		if(!\dash\app::isset_request('paydate')) unset($args['paydate']);
		if(!\dash\app::isset_request('payamount')) unset($args['payamount']);
		if(!\dash\app::isset_request('paybank')) unset($args['paybank']);
		if(!\dash\app::isset_request('paytype')) unset($args['paytype']);
		if(!\dash\app::isset_request('paynumber')) unset($args['paynumber']);
		if(!\dash\app::isset_request('gift')) unset($args['gift']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);

		if(!empty($args))
		{
			$update = \lib\db\send::update($args, $id);
			\dash\log::set('editSend', ['code' => $id]);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
		}
	}

	/**
	 * ready data of send to load in api
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

				default:
					$result[$key] = $value;
					break;
			}
		}

		$result = \dash\app::ready($result);

		return $result;
	}

}
?>