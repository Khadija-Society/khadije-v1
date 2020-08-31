<?php
namespace lib\app;

/**
 * Class for protectagentuser.
 */
class protectagentuser
{

	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("protectagentuser id not set"));
			return false;
		}

		$get = \lib\db\protectionagentuser::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid protectagentuser id"));
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

		$args    = [];
		$user_id = null;


		$occation_id = \dash\app::request('occation_id');
		if(!$occation_id || !\dash\coding::is($occation_id))
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$load_occasion = \lib\app\occasion::get($occation_id);
		if(isset($load_occasion['status']))
		{
			if($load_occasion['status'] === 'registring')
			{
				// ok nothing
			}
			else
			{
				\dash\notif::error(T_("Can not add any user to this occasion. The occasion status is not registring"));
				return false;
			}
		}
		else
		{
			\dash\notif::error(T_("Invalid occasion id"));
			return false;
		}

		$occation_id = \dash\coding::decode($occation_id);

		$mobile = \dash\app::request('mobile');
		$mobile = \dash\utility\filter::mobile($mobile);

		if(!$mobile)
		{
			\dash\notif::error(T_("Please enter mobile"));
			return false;
		}

		$check_mobile = \dash\db\users::get_by_mobile($mobile);
		if(isset($check_mobile['id']))
		{
			$user_id = $check_mobile['id'];
		}
		else
		{
			$load_user = \dash\db\users::signup(['mobile' => $mobile]);
			if($load_user)
			{
				$user_id = $load_user;
			}
		}

		$nationalcode = \dash\app::request('nationalcode');
		if(!$nationalcode)
		{
			\dash\notif::error(T_("Please enter nationalcode"));
			return false;
		}

		if(!\dash\utility\filter::nationalcode($nationalcode))
		{
			\dash\notif::error(T_("Invalid nationalcode"));
			return false;
		}


		$displayname = \dash\app::request('displayname');
		$displayname = trim($displayname);
		if(!$displayname)
		{
			\dash\notif::error(T_("Please fill the protectagentuser displayname"), 'displayname');
			return false;
		}

		if(mb_strlen($displayname) > 100)
		{
			\dash\notif::error(T_("Please fill the displayname displayname less than 100 character"), 'displayname');
			return false;
		}

		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			\dash\noif::error(T_("Invalid agent id"));
			return false;
		}

		$check_duplicate =
		[
			'protection_occasion_id' => \dash\coding::decode($load_occasion['id']),
			'protection_agent_id'    => $protection_agent_id,
			'nationalcode'           => $nationalcode,
			'limit'                  => 1,
		];

		$check_duplicate = \lib\db\protectionagentuser::get($check_duplicate);

		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				\dash\notif::error(T_("This user already added to your list"), 'nationalcode');
				return false;
			}
		}


		$type = \dash\app::request('type');
		if($type && mb_strlen($type) > 150)
		{
			\dash\notif::error(T_("Please fill the protectagentuser type less than 150 character"), 'type');
			return false;
		}

		$status = \dash\app::request('status');
		if($status && !in_array($status, ['request', 'accept', 'reject']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}

		$desc     = \dash\app::request('desc');
		$address  = \dash\app::request('address');

		$province = \dash\app::request('province');
		$city     = \dash\app::request('city');

		$postalcode = \dash\app::request('postalcode');

		$args['protection_occasion_id'] = $occation_id;
		$args['protection_agent_id']    = $protection_agent_id;
		$args['mobile']                 = $mobile;
		$args['user_id']                 = $user_id;
		// $args['protection_user_id']     = $user_id;
		$args['nationalcode']           = $nationalcode;
		$args['displayname']            = $displayname;
		$args['type']                   = $type;
		$args['status']                 = $status;
		$args['desc']                   = $desc;
		$args['address']                = $address;
		$args['province']               = $province;
		$args['city']                   = $city;
		$args['postalcode']             = $postalcode;

		return $args;
	}





	/**
	 * add new protectagentuser
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
			$args['status']  = 'request';
		}

		$args['datecreated'] = date("Y-m-d H:i:s");

		$protectagentuser_id = \lib\db\protectionagentuser::insert($args);

		if(!$protectagentuser_id)
		{
			\dash\log::set('apiprotectAgentUser:no:way:to:insertprotectAgentUser');
			\dash\notif::error(T_("No way to insert protectagentuser"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($protectagentuser_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewprotectAgentUser', ['code' => $protectagentuser_id]);
			\dash\notif::ok(T_("protectAgentUser successfuly added"));
		}

		return $return;
	}



	public static $sort_field =
	[
		'id',
	];


	/**
	 * Gets the protectagentuser.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The protectagentuser.
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

		$result            = \lib\db\protectionagentuser::search($_string, $_args);
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
	 * edit a protectagentuser
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
		if(!\dash\app::isset_request('type')) unset($args['type']);
		if(!\dash\app::isset_request('status')) unset($args['status']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('address')) unset($args['address']);
		if(!\dash\app::isset_request('bankaccountnumber')) unset($args['bankaccountnumber']);
		if(!\dash\app::isset_request('bankshaba')) unset($args['bankshaba']);
		if(!\dash\app::isset_request('bankhesab')) unset($args['bankhesab']);
		if(!\dash\app::isset_request('bankcart')) unset($args['bankcart']);
		if(!\dash\app::isset_request('bankname')) unset($args['bankname']);
		if(!\dash\app::isset_request('bankownername')) unset($args['bankownername']);
		if(!\dash\app::isset_request('province')) unset($args['province']);
		if(!\dash\app::isset_request('city')) unset($args['city']);


		if(!empty($args))
		{
			$update = \lib\db\protectionagentuser::update($args, $id);
			\dash\log::set('editprotectAgentUser', ['code' => $id]);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
		}
	}

	/**
	 * ready data of protectagentuser to load in api
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