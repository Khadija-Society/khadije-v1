<?php
namespace lib\app;

/**
 * Class for protectagentuser.
 */
class protectagentuser
{

	public static function update_status($_occasion_id, $_id, $_status)
	{
		$occation_id = \dash\coding::decode($_occasion_id);
		if(!$occation_id)
		{
			\dash\notif::error(T_("Invalid occasion id"));
			return false;
		}

		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$get =
		[
			'id'                     => $id,
			'protection_occasion_id' => $occation_id,
			'limit'                  => 1
		];

		$get = \lib\db\protectionagentuser::get($get);
		if(isset($get['id']))
		{
			$update = \lib\db\protectionagentuser::update(['status' => $_status], $id);
			\dash\notif::ok(T_("Status changed"));
			return true;
		}
		else
		{
			\dash\notif::error(T_("Data not found"));
			return false;
		}
	}



	public static function occasion_list_by_child($_occasion_id, $_user_id)
	{
		$load_occasion = \lib\app\occasion::get($_occasion_id);

		if(!$load_occasion)
		{
			return false;
		}

		$creator = \lib\db\protectionagentoccasionchild::get_creator_id_from_child(\dash\coding::decode($load_occasion['id']), \dash\user::id());


		$list = \lib\db\protectionagentuser::admin_get(['protection_occasion_id' => \dash\coding::decode($_occasion_id), 'creator' => $creator]);

		if(!is_array($list))
		{
			$list = [];
		}

		$list = array_map(['self', 'ready'], $list);

		return $list;

	}

	public static function occasion_list($_occasion_id)
	{
		$load_occasion = \lib\app\occasion::get($_occasion_id);

		if(!$load_occasion)
		{
			return false;
		}

		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			\dash\notif::error(T_("Invalid agent id"));
			return false;
		}

		$list = \lib\db\protectionagentuser::admin_get(['protection_occasion_id' => \dash\coding::decode($_occasion_id), 'protection_agent_id' => $protection_agent_id]);

		if(!is_array($list))
		{
			$list = [];
		}

		$list = array_map(['self', 'ready'], $list);

		return $list;

	}

	public static function occasion_list_count($_occasion_id)
	{
		$load_occasion = \lib\app\occasion::get($_occasion_id);

		if(!$load_occasion)
		{
			return false;
		}

		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			\dash\notif::error(T_("Invalid agent id"));
			return false;
		}

		$count = \dash\db\config::public_get_count('protection_user_agent_occasion', ['protection_occasion_id' => \dash\coding::decode($_occasion_id), 'protection_agent_id' => $protection_agent_id]);

		return $count;

	}





	public static function admin_occasion_list_count($_occasion_id, $_agent_id)
	{
		$load_occasion = \lib\app\occasion::get($_occasion_id);

		if(!$load_occasion)
		{
			return false;
		}

		$agent_id = \dash\coding::decode($_agent_id);
		if(!$agent_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$count = \dash\db\config::public_get_count('protection_user_agent_occasion', ['protection_occasion_id' => \dash\coding::decode($_occasion_id), 'protection_agent_id' => $agent_id]);

		return $count;

	}


	public static function admin_occasion_list($_occasion_id, $_agent_id, $_args = [])
	{
		$load_occasion = \lib\app\occasion::get($_occasion_id);

		if(!$load_occasion)
		{
			return false;
		}

		$agent_id = \dash\coding::decode($_agent_id);
		if(!$agent_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$list = \lib\db\protectionagentuser::admin_get(['protection_occasion_id' => \dash\coding::decode($_occasion_id), 'protection_agent_id' => $agent_id], $_args);

		if(!is_array($list))
		{
			$list = [];
		}

		$list = array_map(['self', 'ready'], $list);

		return $list;

	}


	public static function get_by_id($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("id not set"));
			return false;
		}

		$get = \lib\db\protectionagentuser::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$result = self::ready($get);

		return $result;
	}



	public static function get($_args)
	{
		$occation_id         = isset($_args['occation_id']) ? \dash\coding::decode($_args['occation_id']) : null;
		$protectagentuser_id = isset($_args['protectagentuser_id']) ? \dash\coding::decode($_args['protectagentuser_id']) : null;

		if(!$occation_id)
		{
			\dash\notif::error(T_("Invalid occasion id"));
			return false;
		}


		if(!$protectagentuser_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			$protection_agent_id = \lib\db\protectionagentoccasionchild::get_agent_id_from_child($occation_id, \dash\user::id());
			if(!$protection_agent_id)
			{
				\dash\notif::error(T_("Invalid agent id"));
				return false;
			}

		}

		$check =
		[
			'id'                     => $protectagentuser_id,
			'protection_occasion_id' => $occation_id,
			'protection_agent_id'    => $protection_agent_id,
			'limit'                  => 1,
		];

		$result = \lib\db\protectionagentuser::get($check);

		if(isset($result['id']))
		{
			return self::ready($result);
		}
		else
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


	}




	public static function admin_get($_args)
	{
		$occation_id         = isset($_args['occation_id']) ? \dash\coding::decode($_args['occation_id']) : null;
		$protectagentuser_id = isset($_args['protectagentuser_id']) ? \dash\coding::decode($_args['protectagentuser_id']) : null;

		if(!$occation_id)
		{
			\dash\notif::error(T_("Invalid occasion id"));
			return false;
		}


		if(!$protectagentuser_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$check =
		[
			'id'                     => $protectagentuser_id,
			'protection_occasion_id' => $occation_id,
			'limit'                  => 1,
		];

		$result = \lib\db\protectionagentuser::get($check);

		if(isset($result['id']))
		{
			return self::ready($result);
		}
		else
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


	}


	public static function remove($_args)
	{
		$occation_id         = isset($_args['occation_id']) ? \dash\coding::decode($_args['occation_id']) : null;
		$protectagentuser_id = isset($_args['protectagentuser_id']) ? \dash\coding::decode($_args['protectagentuser_id']) : null;

		if(!$occation_id)
		{
			\dash\notif::error(T_("Invalid occasion id"));
			return false;
		}


		if(!$protectagentuser_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			if(a($_args, 'accessAsChild'))
			{
				$protection_agent_id = \lib\db\protectionagentoccasionchild::get_agent_id_from_child($occation_id, \dash\user::id());
				if(!$protection_agent_id)
				{
					\dash\notif::error(T_("Invalid agent id"));
					return false;
				}

			}
			else
			{
				\dash\notif::error(T_("Invalid agent id"));
				return false;
			}
		}


		$check =
		[
			'id'                     => $protectagentuser_id,
			'protection_occasion_id' => $occation_id,
			'protection_agent_id'    => $protection_agent_id,
			'limit'                  => 1,
		];

		$result = \lib\db\protectionagentuser::get($check);

		if(isset($result['id']))
		{
			$result = \lib\db\protectionagentuser::remove($result['id']);
			\dash\notif::ok(T_("Removed"));
			return true;

		}
		else
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


	}



	public static function admin_remove($_args)
	{
		$occation_id         = isset($_args['occation_id']) ? \dash\coding::decode($_args['occation_id']) : null;
		$protectagentuser_id = isset($_args['protectagentuser_id']) ? \dash\coding::decode($_args['protectagentuser_id']) : null;

		if(!$occation_id)
		{
			\dash\notif::error(T_("Invalid occasion id"));
			return false;
		}


		if(!$protectagentuser_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


		$check =
		[
			'id'                     => $protectagentuser_id,
			'protection_occasion_id' => $occation_id,
			'limit'                  => 1,
		];

		$result = \lib\db\protectionagentuser::get($check);

		if(isset($result['id']))
		{
			$result = \lib\db\protectionagentuser::remove($result['id']);
			\dash\notif::ok(T_("Removed"));
			return true;

		}
		else
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


	}


	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_id = null)
	{


		$nationalcode = null;
		$pasportcode = null;

		$is_admin = false;
		if(\dash\app::request('is_admin'))
		{
			$is_admin = true;
		}

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

		$country = \dash\app::request('country');
		if($country && !\dash\utility\location\countres::check($country))
		{
			\dash\notif::error(T_("Invalid country"), 'country');
			return false;
		}

		if(!$country)
		{
			\dash\notif::error(T_("country is required"));
			return false;
		}


		$pasportcode = \dash\app::request('pasportcode');
		if(mb_strlen($pasportcode) > 100)
		{
			\dash\notif::error(T_("Please fill the pasportcode less than 100 character"), 'pasportcode');
			return false;
		}


		if($is_admin)
		{
			$protection_agent_id = \dash\app::request('protection_agent_id');
			$protection_agent_id = \dash\coding::decode($protection_agent_id);
		}
		elseif(\dash\app::request('accessAsChild'))
		{
			$protection_agent_id = \lib\db\protectionagentoccasionchild::get_agent_id_from_child(\dash\coding::decode($load_occasion['id']), \dash\user::id());
			if(!$protection_agent_id)
			{
				\dash\notif::error(T_("Invalid agent id"));
				return false;
			}

			if(!$_id)
			{
				// in add new chaild check capacity
				$access_detail = \lib\db\protectionagentoccasionchild::get_detail_from_child(\dash\coding::decode($load_occasion['id']), \dash\user::id());
				if(isset($access_detail['capacity']) && is_numeric($access_detail['capacity']))
				{
					$creator = \lib\db\protectionagentoccasionchild::get_creator_id_from_child(\dash\coding::decode($load_occasion['id']), \dash\user::id());
					$total_added_by_me = \lib\db\protectionagentuser::get_count(['protection_occasion_id' => \dash\coding::decode($load_occasion['id']), 'creator' => $creator]);

					$total_added_by_me = floatval($total_added_by_me);
					if($total_added_by_me >= floatval($access_detail['capacity']))
					{
						\dash\notif::error(T_("Your capacity is full. You can not add any user to this list"));
						return false;
					}

				}

			}


		}
		else
		{
			$protection_agent_id = \lib\app\protectagent::get_current_id();
			if(!$protection_agent_id)
			{
				\dash\notif::error(T_("Invalid agent id"));
				return false;
			}
		}




		$check_duplicate =
		[
			'protection_occasion_id' => \dash\coding::decode($load_occasion['id']),
			'protection_agent_id'    => $protection_agent_id,
			'limit'                  => 1,
		];

		if($country === 'IR')
		{

			$nationalcode = \dash\app::request('nationalcode');
			if(!$nationalcode)
			{
				\dash\notif::error(T_("Please enter nationalcode"), 'nationalcode');
				return false;
			}

			if(!\dash\utility\filter::nationalcode($nationalcode))
			{
				\dash\notif::error(T_("Invalid nationalcode"));
				return false;
			}

			$check_duplicate['nationalcode'] = $nationalcode;
			$pasportcode = null;
		}
		else
		{
			if(!$pasportcode)
			{
				\dash\notif::error(T_("Please enter pasportcode"), 'pasportcode');
				return false;
			}
			$check_duplicate['pasportcode'] = $pasportcode;
			$nationalcode = null;
		}

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

		// remove this agent
		unset($check_duplicate['protection_agent_id']);

		$check_duplicate = \lib\db\protectionagentuser::get($check_duplicate);

		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				\dash\notif::error(T_("This user already added to this occasion list"), 'nationalcode');
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



		$city = \dash\app::request('city');
		if($city && !\dash\utility\location\cites::check($city))
		{
			\dash\notif::error(T_("Invalid city"), 'city');
			return false;
		}

		if(!$city)
		{
			\dash\notif::error(T_("City is required"));
			return false;
		}


		$province = null;
		if($city)
		{
			$province = \dash\utility\location\cites::get($city, 'province', 'province');
			if(!\dash\utility\location\provinces::check($province))
			{
				$province = null;
			}
		}

		$married = \dash\app::request('married');
		if($married && !in_array($married, ['single', 'married']))
		{
			\dash\notif::error(T_("Invalid arguments married"), 'married');
			return false;
		}

		$gender = \dash\app::request('gender');
		if($gender && !in_array($gender, ['male', 'female']))
		{
			\dash\notif::error(T_("Invalid arguments gender"), 'gender');
			return false;
		}

		$desc     = \dash\app::request('desc');
		$address  = \dash\app::request('address');

		$postalcode = \dash\app::request('postalcode');

		$type_id = \dash\app::request('type_id');
		if($type_id)
		{
			$type_id = \dash\coding::decode($type_id);
			if(!$type_id)
			{
				\dash\notif::error(T_("Invalid id"));
				return false;
			}

		}

		$protectioncount = \dash\app::request('protectioncount');
		if($protectioncount && !is_numeric($protectioncount))
		{
			\dash\notif::error(T_("Please set protection count as a number"));
			return false;
		}

		if($protectioncount)
		{
			if(floatval($protectioncount) > 100)
			{
				\dash\notif::error(T_("Please set protection count less than 100"));
				return false;
			}
		}

		$file1 = \dash\app::request('file1');
		$file2 = \dash\app::request('file2');

		if(\dash\app::request('accessAsChild'))
		{
			$creator = \lib\db\protectionagentoccasionchild::get_creator_id_from_child(\dash\coding::decode($load_occasion['id']), \dash\user::id());
			if($creator)
			{
				$args['creator'] = $creator;
			}
		}

		$args['protection_occasion_id'] = $occation_id;
		$args['protection_agent_id']    = $protection_agent_id;
		$args['mobile']                 = $mobile;
		$args['user_id']                = $user_id;
		$args['protectioncount']        = $protectioncount;
		// $args['protection_user_id']  = $user_id;
		$args['type_id']                = $type_id;
		$args['nationalcode']           = $nationalcode;
		$args['displayname']            = $displayname;
		$args['type']                   = $type;
		$args['married']                = $married;
		$args['gender']                 = $gender;
		$args['status']                 = $status;
		$args['desc']                   = $desc;
		$args['address']                = $address;
		$args['province']               = $province;
		$args['city']                   = $city;
		$args['postalcode']             = $postalcode;
		$args['file1']                  = $file1;
		$args['file2']                  = $file2;
		$args['country']                = $country;
		$args['pasportcode']            = $pasportcode;

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

		$result = self::get_by_id($_id);

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


		if(!\dash\app::isset_request('occation_id')) unset($args['occation_id']);
		if(!\dash\app::isset_request('mobile')) unset($args['mobile']);
		if(!\dash\app::isset_request('nationalcode')) unset($args['nationalcode']);
		if(!\dash\app::isset_request('displayname')) unset($args['displayname']);
		if(!\dash\app::isset_request('type')) unset($args['type']);
		if(!\dash\app::isset_request('status')) unset($args['status']);
		if(!\dash\app::isset_request('city')) unset($args['city']);
		if(!\dash\app::isset_request('married')) unset($args['married']);
		if(!\dash\app::isset_request('gender')) unset($args['gender']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('address')) unset($args['address']);
		if(!\dash\app::isset_request('postalcode')) unset($args['postalcode']);
		if(!\dash\app::isset_request('type_id')) unset($args['type_id']);
		if(!\dash\app::isset_request('protectioncount')) unset($args['protectioncount']);
		if(!\dash\app::isset_request('file1')) unset($args['file1']);
		if(!\dash\app::isset_request('file2')) unset($args['file2']);
		if(!\dash\app::isset_request('pasportcode')) unset($args['pasportcode']);
		if(!\dash\app::isset_request('country')) unset($args['country']);

		if(!empty($args))
		{
			$update = \lib\db\protectionagentuser::update($args, $id);

			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("Data successfully updated"));
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
		$result['location_string'] = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
				case 'protection_occasion_id':
				case 'protection_user_id':
				case 'protection_agent_id':
				case 'user_id':
				case 'type_id':
					$result[$key] = \dash\coding::encode($value);
					break;

				case 'country':
					$result[$key] = $value;
					$result['country_name'] = \dash\utility\location\countres::get_localname($value, true);
					// $result['location_string'][1] = $result['country_name'];
					break;


				case 'province':
					$result[$key] = $value;
					$result['province_name'] = \dash\utility\location\provinces::get_localname($value);
					$result['location_string'][2] = $result['province_name'];
					break;

				case 'city':
					$result[$key] = $value;
					$result['city_name'] = \dash\utility\location\cites::get_localname($value);
					$result['location_string'][3] = $result['city_name'];
					break;

				default:
					$result[$key] = $value;
					break;
			}
		}

		$result['location_string'] = implode(' - ', $result['location_string']);

		return $result;
	}

}
?>