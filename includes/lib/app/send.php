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

			if($job && !in_array($job, ['clergy', 'adminoffice', 'admin', 'missionary', 'servant']))
			{
				\dash\notif::error(T_("Invalid job"));
				return false;
			}
		}




		$startdate      = \dash\app::request('startdate');
		if(\dash\app::isset_request('startdate'))
		{

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

		}

		$enddate        = \dash\app::request('enddate');
		if(\dash\app::isset_request('enddate'))
		{
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


			if($user_id && $city && $job && $startdate && $enddate)
			{
				$check_duplicate =
				[
					'agent_send.user_id'   => $user_id,
					'agent_send.city'      => $city,
					'agent_send.job'       => $job,
					'agent_send.startdate' => $startdate,
					'agent_send.enddate'   => $enddate,
					'limit'                 => 1
				];

				$check_duplicate = \lib\db\send::get($check_duplicate);
				if(isset($check_duplicate['id']))
				{
					$msg = T_("Duplicate dispatch");
					\dash\notif::error($msg, ['element' => ['startdate', 'enddate']]);
					return false;
				}

			}
		}




		$assessmentdate = \dash\app::request('assessmentdate');
		$assessmentor   = \dash\app::request('assessmentor');
		$assessmentdesc = \dash\app::request('assessmentdesc');

		$score          = \dash\app::request('score');
		$percent          = \dash\app::request('percent');

		$paydate        = \dash\app::request('paydate');

		if(\dash\app::isset_request('paydate'))
		{

			$paydate                 = \dash\utility\convert::to_en_number($paydate);
			if(\dash\utility\jdate::is_jalali($paydate))
			{
				$paydate = \dash\utility\jdate::to_gregorian($paydate);
			}

			if(!$paydate)
			{
				\dash\notif::error(T_("Pay date is required"), 'paydate');
				return false;
			}

		}

		$payamount      = \dash\app::request('payamount');

		if(\dash\app::isset_request('payamount'))
		{
			$payamount                 = \dash\utility\convert::to_en_number($payamount);
			if(!is_numeric($payamount))
			{
				\dash\notif::error(T_("Please set amount as a number"), 'payamount');
				return false;
			}

			if(intval($payamount) > 999999999)
			{
				\dash\notif::error(T_("Amount is out of range"), 'payamount');
				return false;
			}
		}

		$paybank        = \dash\app::request('paybank');

		if($paybank && mb_strlen($paybank) > 100)
		{
			\dash\notif::error(T_("Data is out of range"), 'paybank');
			return false;
		}

		$paytype        = \dash\app::request('paytype');
		if($paytype && mb_strlen($paytype) > 100)
		{
			\dash\notif::error(T_("Data is out of range"), 'paytype');
			return false;
		}
		$paynumber      = \dash\app::request('paynumber');
		if($paynumber && mb_strlen($paynumber) > 100)
		{
			\dash\notif::error(T_("Data is out of range"), 'paynumber');
			return false;
		}

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
		$args['percent']          = $percent;
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
		if(!\dash\app::isset_request('percent')) unset($args['percent']);
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