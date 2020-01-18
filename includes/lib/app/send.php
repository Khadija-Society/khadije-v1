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


		$clergy        = \dash\app::request('clergy');
		if(\dash\app::isset_request('clergy') && $clergy)
		{
			$clergy = \dash\coding::decode($clergy);
			if(!$clergy)
			{
				\dash\notif::error(T_("Invalid clergy"), 'clergy');
				return false;
			}


			$check_clergy = \dash\db\users::get_by_id($clergy);

			if(!isset($check_clergy['id']))
			{
				\dash\notif::error(T_("Clergy not found"), 'clergy');
				return false;
			}

			if($city)
			{
				$check_access_clergy = \lib\db\servant::get(['agent_servant.user_id' => $clergy, 'agent_servant.city' => $city, 'agent_servant.job' => 'clergy', 'limit' => 1]);

				if(!isset($check_access_clergy['id']))
				{
					\dash\notif::error(T_("This user have not access to set clergy of this city"));
					return false;
				}
			}
		}
		else
		{
			$clergy = null;
		}



		$servant        = \dash\app::request('servant');
		if(\dash\app::isset_request('servant') && $servant)
		{
			$servant = \dash\coding::decode($servant);
			if(!$servant)
			{
				\dash\notif::error(T_("Invalid servant"), 'servant');
				return false;
			}


			$check_servant = \dash\db\users::get_by_id($servant);

			if(!isset($check_servant['id']))
			{
				\dash\notif::error(T_("Clergy not found"), 'servant');
				return false;
			}

			if($city)
			{
				$check_access_servant = \lib\db\servant::get(['agent_servant.user_id' => $servant, 'agent_servant.city' => $city, 'agent_servant.job' => 'servant', 'limit' => 1]);

				if(!isset($check_access_servant['id']))
				{
					\dash\notif::error(T_("This user have not access to set servant of this city"));
					return false;
				}
			}
		}
		else
		{
			$servant = null;
		}



		$admin        = \dash\app::request('admin');
		if(\dash\app::isset_request('admin') && $admin)
		{
			$admin = \dash\coding::decode($admin);
			if(!$admin)
			{
				\dash\notif::error(T_("Invalid admin"), 'admin');
				return false;
			}

			$check_admin = \dash\db\users::get_by_id($admin);
			if(!isset($check_admin['id']))
			{
				\dash\notif::error(T_("Clergy not found"), 'admin');
				return false;
			}

			if($city)
			{
				$check_access_admin = \lib\db\servant::get(['agent_servant.user_id' => $admin, 'agent_servant.city' => $city, 'agent_servant.job' => 'admin', 'limit' => 1]);
				if(!isset($check_access_admin['id']))
				{
					\dash\notif::error(T_("This user have not access to set admin of this city"));
					return false;
				}
			}
		}
		else
		{
			$admin = null;
		}



		$adminoffice        = \dash\app::request('adminoffice');
		if(\dash\app::isset_request('adminoffice') && $adminoffice)
		{
			$adminoffice = \dash\coding::decode($adminoffice);
			if(!$adminoffice)
			{
				\dash\notif::error(T_("Invalid adminoffice"), 'adminoffice');
				return false;
			}

			$check_adminoffice = \dash\db\users::get_by_id($adminoffice);
			if(!isset($check_adminoffice['id']))
			{
				\dash\notif::error(T_("Clergy not found"), 'adminoffice');
				return false;
			}

			if($city)
			{
				$check_access_adminoffice = \lib\db\servant::get(['agent_servant.user_id' => $adminoffice, 'agent_servant.city' => $city, 'agent_servant.job' => 'adminoffice', 'limit' => 1]);
				if(!isset($check_access_adminoffice['id']))
				{
					\dash\notif::error(T_("This user have not access to set adminoffice of this city"));
					return false;
				}
			}
		}
		else
		{
			$adminoffice = null;
		}





		$missionary        = \dash\app::request('missionary');
		if(\dash\app::isset_request('missionary') && $missionary)
		{
			$missionary = \dash\coding::decode($missionary);
			if(!$missionary)
			{
				\dash\notif::error(T_("Invalid missionary"), 'missionary');
				return false;
			}

			$check_missionary = \dash\db\users::get_by_id($missionary);
			if(!isset($check_missionary['id']))
			{
				\dash\notif::error(T_("Clergy not found"), 'missionary');
				return false;
			}

			if($city)
			{
				$check_access_missionary = \lib\db\servant::get(['agent_servant.user_id' => $missionary, 'agent_servant.city' => $city, 'agent_servant.job' => 'missionary', 'limit' => 1]);
				if(!isset($check_access_missionary['id']))
				{
					\dash\notif::error(T_("This user have not access to set missionary of this city"));
					return false;
				}
			}
		}
		else
		{
			$missionary = null;
		}


		$place_id       = \dash\app::request('place_id');
		if(\dash\app::isset_request('place_id'))
		{

			$place_id = \dash\coding::decode($place_id);
			if(!$place_id)
			{
				\dash\notif::error("لطفا زائرسرا را انتخاب کنید", 'palce');
				return false;
			}

			$check_place = \lib\db\agentplace::get(['id' => $place_id, 'limit' => 1]);
			if(!isset($check_place['id']))
			{
				\dash\notif::error(T_("Place not found"), 'palce');
				return false;
			}

			if($city)
			{
				$check_place_city = \lib\db\agentplace::get(['id' => $place_id, '1.1' => [' = 1.1 AND ', " (city IS NULL OR  city = '$city') "], 'limit' => 1]);
				if(!isset($check_place_city['id']))
				{
					\dash\notif::error(T_("Place and city not mathc"), 'city');
					return false;
				}

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

		$args['clergy_id']      = $clergy;
		$args['admin_id']       = $admin;
		$args['adminoffice_id'] = $adminoffice;
		$args['missionary_id']  = $missionary;
		$args['servant_id']  = $servant;

		$args['place_id']       = $place_id;

		$args['city']           = $city;

		$args['startdate']      = $startdate;
		$args['enddate']        = $enddate;

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

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("user not found"), 'user');
			return false;
		}

		if(isset($_args['mobile']) && $_args['mobile'])
		{

			$user_id = \dash\app\user::add($_args);
			if(isset($user_id['id']))
			{
				$_args['admin_id'] = $user_id['id'];
			}
		}

		\dash\app::variable($_args);

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

		if(!\dash\app::isset_request('clergy')) unset($args['clergy_id']);
		if(!\dash\app::isset_request('admin')) unset($args['admin_id']);
		if(!\dash\app::isset_request('adminoffice')) unset($args['adminoffice_id']);
		if(!\dash\app::isset_request('servant')) unset($args['servant_id']);
		if(!\dash\app::isset_request('missionary')) unset($args['missionary_id']);


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
				case 'id':
				case 'place_id':
				case 'user_id':
				case 'clergy_id':
				case 'admin_id':
				case 'missionary_id':
				case 'adminoffice_id':
				case 'servant_id':
					if($value)
					{
						$value = \dash\coding::encode($value);
					}
					$result[$key] = $value;
					break;

		   		case 'displayname':
		   		case 'clergy_displayname':
		   		case 'admin_displayname':
		   		case 'adminoffice_displayname':
		   		case 'missionary_displayname':
		   		case 'servant_displayname':
					if(!$value && $value != '0')
					{
						$value = T_("Whitout name");
					}
					$result[$key] = $value;
					break;

				case 'avatar':
				case 'clergy_avatar':
		   		case 'admin_avatar':
		   		case 'adminoffice_avatar':
		   		case 'missionary_avatar':
		   		case 'servant_avatar':
					if($value)
					{
						$avatar = $value;
					}
					else
					{
						if(isset($_data['gender']))
						{
							if($_data['gender'] === 'male')
							{
								$avatar = \dash\app::static_avatar_url('male');
							}
							else
							{
								$avatar = \dash\app::static_avatar_url('female');
							}
						}
						else
						{
							$avatar = \dash\app::static_avatar_url();
						}
					}
					$result[$key] = $avatar;
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