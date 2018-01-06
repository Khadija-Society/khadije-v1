<?php
namespace lib\app;

class myuser
{
	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_option = [])
	{
		$default_option =
		[
			'debug' => true,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);


		$gender = \lib\app::request('gender');
		if($gender && !in_array($gender, ['male', 'female']))
		{
			\lib\debug::error(T_("Invalid arguments gender"), 'gender');
			return false;
		}

		$email = \lib\app::request('email');
		if($email && mb_strlen($email) > 70)
		{
			\lib\debug::error(T_("Invalid arguments email"), 'email');
			return false;
		}

		$birthday = \lib\app::request('birthday');
		$birthday = \lib\utility\convert::to_en_number($birthday);
		if(!$birthday)
		{
			\lib\debug::error(T_("Birthday is required"), 'birthday');
			return false;
		}

		if(strtotime($birthday) === false)
		{
			\lib\debug::error(T_("Invalid arguments birthday"), 'birthday');
			return false;
		}

		if($birthday)
		{
			$birthday = date("Y-m-d", strtotime($birthday));
		}

		$firstname = \lib\app::request('firstname');

		if(!$firstname)
		{
			\lib\debug::error(T_("First name is required"), 'name');
			return false;
		}

		if($firstname && mb_strlen($firstname) > 50)
		{
			\lib\debug::error(T_("Invalid arguments firstname"), 'name');
			return false;
		}

		$lastname = \lib\app::request('lastname');
		if($lastname && mb_strlen($lastname) > 50)
		{
			\lib\debug::error(T_("Invalid arguments lastname"), 'lastName');
			return false;
		}

		if(!$lastname)
		{
			\lib\debug::error(T_("Last name is required"), 'lastName');
			return false;
		}

		$nationalcode = \lib\app::request('nationalcode');
		$pasportcode = \lib\app::request('pasportcode');

		if(!$nationalcode && !$pasportcode)
		{
			\lib\debug::error(T_("National code or pasportcode code is required"), ['nationalcode', 'pasportcode']);
			return false;
		}


		$nationalcode = \lib\utility\convert::to_en_number($nationalcode);

		if(($nationalcode && !is_numeric($nationalcode)) || ($nationalcode && mb_strlen($nationalcode) <> 10))
		{
			\lib\debug::error(T_("Invalid arguments nationalcode"), 'nationalcode');
			return false;
		}

		if($nationalcode)
		{
			if(\lib\utility\nationalcode::check($nationalcode))
			{
				\lib\db\nationalcodes::add($nationalcode);
			}
			else
			{
				\lib\debug::error(T_("Invalid nationalcode"), 'nationalcode');
				return false;
			}
		}

		$father = \lib\app::request('father');
		if($father && mb_strlen($father) > 50)
		{
			\lib\debug::error(T_("Invalid arguments father"), 'father');
			return false;
		}

		if($pasportcode && mb_strlen($pasportcode) > 50)
		{
			\lib\debug::error(T_("Invalid arguments pasportcode"), 'pasportcode');
			return false;
		}

		$pasportdate = \lib\app::request('pasportdate');
		$pasportdate = \lib\utility\convert::to_en_number($pasportdate);
		if($pasportdate && strtotime($pasportdate) === false)
		{
			\lib\debug::error(T_("Invalid arguments pasportdate"), 'pasportdate');
			return false;
		}

		if($pasportdate)
		{
			$pasportdate = date("Y-m-d", strtotime($pasportdate));
		}

		$education = \lib\app::request('education');
		if($education && mb_strlen($education) > 50)
		{
			\lib\debug::error(T_("Invalid arguments education"), 'education');
			return false;
		}

		$educationcourse = \lib\app::request('educationcourse');
		if($educationcourse && mb_strlen($educationcourse) > 50)
		{
			\lib\debug::error(T_("Invalid arguments educationcourse"), 'educationcourse');
			return false;
		}

		$country = \lib\app::request('country');
		if($country && mb_strlen($country) > 50)
		{
			\lib\debug::error(T_("Invalid arguments country"), 'country');
			return false;
		}

		$province = \lib\app::request('province');
		if($province && mb_strlen($province) > 50)
		{
			\lib\debug::error(T_("Invalid arguments province"), 'province');
			return false;
		}

		$city = \lib\app::request('city');
		if($city && mb_strlen($city) > 50)
		{
			\lib\debug::error(T_("Invalid arguments city"), 'city');
			return false;
		}

		$homeaddress = \lib\app::request('homeaddress');
		if($homeaddress && mb_strlen($homeaddress) > 700)
		{
			\lib\debug::error(T_("Invalid arguments homeaddress"), 'homeaddress');
			return false;
		}

		$workaddress = \lib\app::request('workaddress');
		if($workaddress && mb_strlen($workaddress) > 700)
		{
			\lib\debug::error(T_("Invalid arguments workaddress"), 'workaddress');
			return false;
		}

		$arabiclang = \lib\app::request('arabiclang');
		if($arabiclang && !in_array($arabiclang, ['yes', 'no']))
		{
			\lib\debug::error(T_("Invalid arguments arabiclang"), 'arabiclang');
			return false;
		}

		$phone = \lib\app::request('phone');
		if(($phone && !is_numeric($phone)) || intval($phone) > 1E+10)
		{
			\lib\debug::error(T_("Invalid arguments phone"), 'phone');
			return false;
		}

		$displayname = \lib\app::request('displayname');
		if($displayname && mb_strlen($displayname) > 90)
		{
			\lib\debug::error(T_("Invalid arguments displayname"), 'displayname');
			return false;
		}

		$married = \lib\app::request('married');
		if($married && !in_array($married, ['single', 'married']))
		{
			\lib\debug::error(T_("Invalid arguments married"), 'married');
			return false;
		}

		$zipcode = \lib\app::request('zipcode');
		if(($zipcode && !is_numeric($zipcode)) || intval($zipcode) > 1E+10 )
		{
			\lib\debug::error(T_("Invalid arguments zipcode"), 'zipcode');
			return false;
		}

		$desc = \lib\app::request('desc');
		if($desc && mb_strlen($desc) > 700)
		{
			\lib\debug::error(T_("Invalid arguments desc"), 'desc');
			return false;
		}

		$job = \lib\app::request('job');
		if($job && mb_strlen($job) > 50)
		{
			\lib\debug::error(T_("Invalid arguments job"), 'job');
			return false;
		}

		$avatar = \lib\app::request('avatar');
		if($avatar && mb_strlen($avatar) > 1000)
		{
			\lib\debug::error(T_("Invalid arguments avatar"), 'avatar');
			return false;
		}

		$nesbat = \lib\app::request('nesbat');
		if($nesbat && mb_strlen($nesbat) > 80)
		{
			\lib\debug::error(T_("Invalid arguments nesbat"), 'nesbat');
			return false;
		}

		$provice_list = \lib\utility\location\provinces::list('localname');
		$provice_list = array_unique($provice_list);

		if($province && !in_array($province, $provice_list))
		{
			\lib\debug::error(T_("Invalid province name"), 'province');
			return false;
		}

		$args                    = [];
		$args['gender']          = $gender;
		$args['email']           = $email;
		$args['birthday']        = $birthday;
		$args['firstname']       = $firstname;
		$args['lastname']        = $lastname;
		if($nationalcode)
		{
			$args['nationalcode']    = "(SELECT '$nationalcode')";
		}
		else
		{
			$args['nationalcode']    = null;
		}
		$args['father']          = $father;
		$args['pasportcode']     = $pasportcode;
		$args['pasportdate']     = $pasportdate;
		$args['education']       = $education;
		$args['educationcourse'] = $educationcourse;
		$args['country']         = $country;
		$args['province']        = $province;
		$args['city']            = $city;
		$args['homeaddress']     = $homeaddress;
		$args['workaddress']     = $workaddress;
		$args['arabiclang']      = $arabiclang;
		$args['phone']           = $phone;
		$args['displayname']     = $displayname;
		$args['married']         = $married;
		$args['zipcode']         = $zipcode;
		$args['desc']            = $desc;
		$args['job']             = $job;
		$args['avatar']          = $avatar;
		$args['nesbat']          = $nesbat;

		if($gender && $birthday && $firstname && $lastname && $father && $nationalcode)
		{
			$args['iscompleteprofile'] = 1;
		}
		else
		{
			$args['iscompleteprofile'] = 0;
		}

		return $args;
	}


	/**
	 * ready data of product to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready($_data)
	{
		$result = [];

		if(!is_array($_data))
		{
			return null;
		}

		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
				case 'creator':
					if(isset($value))
					{
						$result[$key] = \lib\utility\shortURL::encode($value);
					}
					else
					{
						$result[$key] = null;
					}
					break;

				default:
					$result[$key] = isset($value) ? (string) $value : null;
					break;
			}
		}
		return $result;
	}

	public static function add_child($_args, $_option = [])
	{

		$default_option =
		[
			'debug' => true,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		\lib\app::variable($_args);

		if(!\lib\user::id())
		{
			\lib\debug::error(T_("User not found"), 'user');
			return false;
		}

		if(!\lib\app::request('travel_id') || !ctype_digit(\lib\app::request('travel_id')))
		{
			\lib\debug::error(T_("Travel id not found"));
			return false;
		}

		// check args
		$args = self::check($_option);

		if($args === false || !\lib\debug::$status)
		{
			return false;
		}

		if(isset($args['nationalcode']) && $args['nationalcode'])
		{
			$load_user = \lib\db\users::get(['id' => \lib\user::id(), 'limit' => 1]);
			if(isset($load_user['nationalcode']) && "(SELECT '$load_user[nationalcode]')" === $args['nationalcode'])
			{
				\lib\debug::error(T_("This nationalcode is for your!"), 'nationalcode');
				return false;
			}

			$duplicate_nationalcode_in_child = \lib\db\travelusers::duplicate_nationalcode_in_child($args['nationalcode'], \lib\app::request('travel_id'));
			if($duplicate_nationalcode_in_child)
			{
				\lib\debug::error(T_("Duplicate national code in your child list"), 'nationalcode');
				return false;
			}
		}

		if(\lib\app::request('type') === 'group')
		{
			$max_count_partner = \lib\app\travel::group_count_partner_max();
		}
		else
		{
			$max_count_partner = \lib\app\travel::trip_count_partner('get');
		}

		$count_partner     = \lib\db\travelusers::get_travel_child(\lib\utility::get('trip'));
		if(count($count_partner) + 1 > intval($max_count_partner) )
		{
			\lib\debug::error(T_("Maximum partner added. can not add another"));
			return false;
		}



		\lib\db\users::insert($args);
		$user_id = \lib\db::insert_id();

		if(!$user_id)
		{
			\lib\debug::error(T_("Can not add partner"), 'db');
			return false;
		}

		$insert_travelusers =
		[
			'user_id'   => $user_id,
			'travel_id' => \lib\app::request('travel_id'),
			'status'    => 'awaiting',
		];

		$result = \lib\db\travelusers::insert($insert_travelusers);

		return $result;
	}

		public static function edit_child($_args, $_id, $_option = [])
	{
		$default_option =
		[
			'debug' => true,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		\lib\app::variable($_args);

		if(!\lib\user::id())
		{
			\lib\debug::error(T_("User not found"), 'user');
			return false;
		}

		if(!$_id || !is_numeric($_id))
		{
			return false;
		}

		$check = \lib\db\users::get(['id' => $_id, 'limit' => 1]);

		if(!isset($check['id']))
		{
			return false;
		}

		// check args
		$args = self::check($_option);

		if($args === false || !\lib\debug::$status)
		{
			return false;
		}

		if(isset($args['nationalcode']) && $args['nationalcode'])
		{
			$load_user = \lib\db\users::get(['id' => \lib\user::id(), 'limit' => 1]);
			if(isset($load_user['nationalcode']) && $load_user['nationalcode'] === $args['nationalcode'])
			{
				\lib\debug::error(T_("This nationalcode is for your!"), 'nationalcode');
				return false;
			}
			$check_not_duplicate_in_child = \lib\db\travelusers::duplicate_nationalcode_in_child($args['nationalcode'], \lib\app::request('travel_id'));

			if(isset($check_not_duplicate_in_child[0]['user_id']))
			{
				if(intval($check_not_duplicate_in_child[0]['user_id']) === intval($_id))
				{
					// no problem to continue;
				}
				else
				{
					\lib\debug::error(T_("Duplicate national code in your child list"), 'nationalcode');
					return false;
				}
			}
		}


		\lib\db\users::update($args, $_id);

		return true;
	}


	/**
	 * add new product
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function edit($_args, $_option = [])
	{
		$default_option =
		[
			'debug' => true,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		\lib\app::variable($_args);

		if(!\lib\user::id())
		{
			\lib\debug::error(T_("User not found"), 'user');
			return false;
		}

		// check args
		$args = self::check($_option);

		if($args === false || !\lib\debug::$status)
		{
			return false;
		}

		if(!\lib\app::isset_request('avatar'))         unset($args['avatar']);

		\lib\db\users::update($args, \lib\user::id());

		\lib\user::update_session(\lib\user::id());

		return true;
	}

}
?>