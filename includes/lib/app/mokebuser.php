<?php
namespace lib\app;

class mokebuser
{

	public static function place_dashboard($_data)
	{
		if(!is_array($_data))
		{
			return $_data;
		}

		$ids_raw = array_column($_data, 'id');

		$result             = [];
		$get_all_full       = [];
		$get_all_full_today = [];

		$ids = array_map(['\\dash\\coding', 'decode'], $ids_raw);
		$ids = array_filter($ids);
		$ids = array_unique($ids);

		if($ids)
		{
			$get_all_full = \lib\db\mokebusers::all_full_place(implode(',', $ids));
			$get_all_full_today = \lib\db\mokebusers::all_full_place_date(implode(',', $ids), date("Y-m-d"));
		}

		foreach ($_data as $key => $value)
		{
			$myId = \dash\coding::decode($value['id']);



			$full_free = self::full_free($value['id']);
			$full = 0;
			$free = 0;
			if(is_array($full_free))
			{
				foreach ($full_free as $k => $v)
				{
					if(isset($v['type']) && $v['type'] === 'free')
					{
						$free++;
					}
					else
					{
						$full++;
					}
				}

			}

			$_data[$key]['free']  = $free;
			$_data[$key]['full']  = $full;

			$_data[$key]['all']   = isset($get_all_full[$myId]) ? $get_all_full[$myId] : 0;
			$_data[$key]['today'] = isset($get_all_full_today[$myId]) ? $get_all_full_today[$myId] : 0;

		}

		return $_data;

	}

	public static function get_expire($_place)
	{
		$place_detail = \lib\app\place::get($_place);
		if(!$place_detail || !isset($place_detail['id']))
		{
			return false;
		}

		if(!$place_detail['activetime'])
		{
			return false;
		}

		$activetime = intval($place_detail['activetime']);

		if(!$place_detail['cleantime'])
		{
			return false;
		}

		$cleantime = $place_detail['cleantime'];
		$cleantime = str_replace(':', '', $cleantime);
		$cleantime = intval($cleantime);

		if($activetime > 24)
		{
			if(intval(date("His")) < $cleantime)
			{
				$activetime = $activetime - 24;
			}
		}

		$expire = $activetime * 60 * 60;
		$expire = date("Y-m-d ". $place_detail['cleantime'], time() + $expire);

 		return $expire;

	}

	public static function list_of_free($_place, $_all = false)
	{

		$place_detail = \lib\app\place::get($_place);
		if(!$place_detail || !isset($place_detail['id']))
		{
			return false;
		}

		$place_id = $place_detail['id'];
		$place_id = \dash\coding::decode($place_id);

		$now = date("Y-m-d H:i:s");

		$all_full = \lib\db\mokebusers::all_full($place_id, $now);

		if(is_array($all_full))
		{
			$all_full = array_map('intval', $all_full);
		}

		if(isset($place_detail['from']) && $place_detail['from'] && isset($place_detail['to']) && $place_detail['to'])
		{
			$from = intval($place_detail['from']);
			$to   = intval($place_detail['to']);
		}
		else
		{
			return false;
		}

		$all_free = [];
		for ($i= $from; $i <= $to ; $i++)
		{
			if(!in_array($i, $all_full))
			{
				$all_free[] = $i;
				if(!$_all)
				{
					break;
				}
			}

		}

		return $all_free;
	}

	public static function full_free($_place)
	{

		$place_detail = \lib\app\place::get($_place);
		if(!$place_detail || !isset($place_detail['id']))
		{
			return false;
		}

		$place_id = $place_detail['id'];
		$place_id = \dash\coding::decode($place_id);

		$now = date("Y-m-d H:i:s");

		$all_full = \lib\db\mokebusers::all_full($place_id, $now);

		if(is_array($all_full))
		{
			$all_full = array_map('intval', $all_full);
		}

		if(isset($place_detail['from']) && $place_detail['from'] && isset($place_detail['to']) && $place_detail['to'])
		{
			$from = intval($place_detail['from']);
			$to   = intval($place_detail['to']);
		}
		else
		{
			return false;
		}

		$all = [];
		for ($i= $from; $i <= $to ; $i++)
		{
			if(!in_array($i, $all_full))
			{
				$all[] = ['type' => 'free', 'number' => $i];
			}
			else
			{
				$all[] = ['type' => 'full', 'number' => $i];
			}
		}

		return $all;
	}


	public static function get_position($_place)
	{
		$position = self::list_of_free($_place);
		if(isset($position[0]))
		{
			return $position[0];
		}
		return null;
	}


	public static function chart_province()
	{
		$list = \lib\db\mokebusers::chart_province();
		$result = [];
		if(is_array($list))
		{
			foreach ($list as $key => $value)
			{
				$map_code = \dash\utility\location\provinces::get($key, null, 'map_code');
				$result[] = [$map_code, intval($value)];
			}
		}

		$result = json_encode($result, JSON_UNESCAPED_UNICODE);
		return $result;

	}

	public static function chart_province_list()
	{
		$list = \lib\db\mokebusers::chart_province();
		$result = [];
		if(is_array($list))
		{
			foreach ($list as $key => $value)
			{
				$map_code = \dash\utility\location\provinces::get($key, null, 'localname');
				$result[] = ['name' => $map_code, 'count' => intval($value)];
			}
		}

		return $result;

	}

	public static function daily_chart()
	{
		$result     = \lib\db\mokebusers::daily_chart();
		$hi_chart   = [];
		$categories = [];
		$values     = [];

		if(is_array($result))
		{
			foreach ($result as $key => $value)
			{
				$categories[] = \dash\datetime::fit($value['date'], null, 'date');
				$values[] = intval($value['count']);
			}
		}

		$hi_chart['categories'] = json_encode($categories, JSON_UNESCAPED_UNICODE);
		$hi_chart['value'] = json_encode($values, JSON_UNESCAPED_UNICODE);
		return $hi_chart;
	}

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


		$gender = \dash\app::request('gender');
		if($gender && !in_array($gender, ['male', 'female']))
		{
			\dash\notif::error(T_("Invalid arguments gender"), 'gender');
			return false;
		}

		if(!$gender)
		{
			\dash\notif::error(T_("Plese set your gender"), 'gender');
			return false;
		}

		$mobile = \dash\app::request('mobile');
		$mobile = \dash\utility\filter::mobile($mobile);

		// if(!$mobile)
		// {
		// 	\dash\notif::error(T_("Invalid mobile"), 'mobile');
		// 	return false;
		// }


		$email = \dash\app::request('email');
		if($email && mb_strlen($email) > 70)
		{
			\dash\notif::error(T_("Invalid arguments email"), 'email');
			return false;
		}

		$birthday = \dash\app::request('birthday');
		// if(!$birthday)
		// {
		// 	\dash\notif::error(T_("Birthday is required"), 'birthday');
		// 	return false;
		// }

		if(\dash\app::isset_request('birthday') && $birthday)
		{


			$birthday = \dash\date::birthdate($birthday, true);

			if($birthday === false)
			{
				return false;
			}
		}

		$firstname = \dash\app::request('firstname');

		// if(!$firstname)
		// {
		// 	\dash\notif::error(T_("First name is required"), 'name');
		// 	return false;
		// }

		if($firstname && mb_strlen($firstname) > 50)
		{
			\dash\notif::error(T_("Invalid arguments firstname"), 'name');
			return false;
		}

		$lastname = \dash\app::request('lastname');
		if($lastname && mb_strlen($lastname) > 50)
		{
			\dash\notif::error(T_("Invalid arguments lastname"), 'lastName');
			return false;
		}

		// if(!$lastname)
		// {
		// 	\dash\notif::error(T_("Last name is required"), 'lastName');
		// 	return false;
		// }

		$nationalcode = \dash\app::request('nationalcode');
		$pasportcode = \dash\app::request('pasportcode');

		if(\dash\app::isset_request('nationalcode') || \dash\app::isset_request('pasportcode'))
		{
			if(!$nationalcode)
			{
				\dash\notif::error(T_("National code is required"), 'nationalcode');
				return false;
			}

			$nationalcode = \dash\utility\convert::to_en_number($nationalcode);

			if(($nationalcode && !is_numeric($nationalcode)) || ($nationalcode && mb_strlen($nationalcode) <> 10))
			{
				\dash\notif::error(T_("Invalid arguments nationalcode"), 'nationalcode');
				return false;
			}

			if(!\dash\utility\filter::nationalcode($nationalcode))
			{
				\dash\notif::error(T_("Invalid nationalcode"), 'nationalcode');
				return false;

			}
		}


		$father = \dash\app::request('father');
		// if(!$father)
		// {
		// 	\dash\notif::error(T_("Father name is required"), 'father');
		// 	return false;
		// }
		if($father && mb_strlen($father) > 50)
		{
			\dash\notif::error(T_("Invalid arguments father"), 'father');
			return false;
		}

		if($pasportcode && mb_strlen($pasportcode) > 50)
		{
			\dash\notif::error(T_("Invalid arguments pasportcode"), 'pasportcode');
			return false;
		}

		$pasportdate = \dash\app::request('pasportdate');
		$pasportdate = \dash\utility\convert::to_en_number($pasportdate);
		if($pasportdate && strtotime($pasportdate) === false)
		{
			\dash\notif::error(T_("Invalid arguments pasportdate"), 'pasportdate');
			return false;
		}

		if($pasportdate)
		{
			$pasportdate = \dash\date::force_gregorian($pasportdate);
			$pasportdate = \dash\date::db($pasportdate);
		}

		$education = \dash\app::request('education');
		if($education && mb_strlen($education) > 50)
		{
			\dash\notif::error(T_("Invalid arguments education"), 'education');
			return false;
		}

		$educationcourse = \dash\app::request('educationcourse');
		if($educationcourse && mb_strlen($educationcourse) > 50)
		{
			\dash\notif::error(T_("Invalid arguments educationcourse"), 'educationcourse');
			return false;
		}

		$country = \dash\app::request('country');
		if($country && mb_strlen($country) > 50)
		{
			\dash\notif::error(T_("Invalid arguments country"), 'country');
			return false;
		}

		$province = \dash\app::request('province');
		if($province && mb_strlen($province) > 50)
		{
			\dash\notif::error(T_("Invalid arguments province"), 'province');
			return false;
		}

		$city = \dash\app::request('city');
		if($city && mb_strlen($city) > 50)
		{
			\dash\notif::error(T_("Invalid arguments city"), 'city');
			return false;
		}

		$homeaddress = \dash\app::request('homeaddress');
		if($homeaddress && mb_strlen($homeaddress) > 700)
		{
			\dash\notif::error(T_("Invalid arguments homeaddress"), 'homeaddress');
			return false;
		}

		// if(!$homeaddress)
		// {
		// 	\dash\notif::error(T_("Address is required"), 'homeaddress');
		// 	return false;
		// }

		$workaddress = \dash\app::request('workaddress');
		if($workaddress && mb_strlen($workaddress) > 700)
		{
			\dash\notif::error(T_("Invalid arguments workaddress"), 'workaddress');
			return false;
		}

		$arabiclang = \dash\app::request('arabiclang');
		if($arabiclang && !in_array($arabiclang, ['yes', 'no']))
		{
			\dash\notif::error(T_("Invalid arguments arabiclang"), 'arabiclang');
			return false;
		}

		$phone = \dash\app::request('phone');
		if(($phone && !is_numeric($phone)) || intval($phone) > 1E+10)
		{
			\dash\notif::error(T_("Invalid arguments phone"), 'phone');
			return false;
		}

		// if(!$phone)
		// {
		// 	\dash\notif::error(T_("Phone is required"), 'phone');
		// 	return false;
		// }

		$displayname = \dash\app::request('displayname');
		if($displayname && mb_strlen($displayname) > 90)
		{
			\dash\notif::error(T_("Invalid arguments displayname"), 'displayname');
			return false;
		}

		$married = \dash\app::request('married');
		if($married && !in_array($married, ['single', 'married']))
		{
			\dash\notif::error(T_("Invalid arguments married"), 'married');
			return false;
		}

		// if(\dash\app::isset_request('married'))
		// {
		// 	if(!$married)
		// 	{
		// 		\dash\notif::error(T_("Plese set your married"), 'married');
		// 		return false;
		// 	}
		// }

		$zipcode = \dash\app::request('zipcode');
		$zipcode = \dash\utility\convert::to_en_number($zipcode);
		if(($zipcode && !is_numeric($zipcode)) || intval($zipcode) > 1E+10 )
		{
			\dash\notif::error(T_("Invalid arguments zipcode"), 'zipcode');
			return false;
		}

		$desc = \dash\app::request('desc');
		if($desc && mb_strlen($desc) > 700)
		{
			\dash\notif::error(T_("Invalid arguments desc"), 'desc');
			return false;
		}

		$job = \dash\app::request('job');
		if($job && mb_strlen($job) > 50)
		{
			\dash\notif::error(T_("Invalid arguments job"), 'job');
			return false;
		}

		$avatar = \dash\app::request('avatar');
		if($avatar && mb_strlen($avatar) > 1000)
		{
			\dash\notif::error(T_("Invalid arguments avatar"), 'avatar');
			return false;
		}

		$nesbat = \dash\app::request('nesbat');
		if($nesbat && mb_strlen($nesbat) > 80)
		{
			\dash\notif::error(T_("Invalid arguments nesbat"), 'nesbat');
			return false;
		}

		if($province && !\dash\utility\location\provinces::check($province))
		{
			\dash\notif::error(T_("Invalid province name"), 'province');
			return false;
		}

		// if($city && !\dash\utility\location\cites::check($city))
		// {
		// 	\dash\notif::error(T_("Invalid city name"), 'city');
		// 	return false;
		// }


		$city = \dash\app::request('city');
		if($city && !\dash\utility\location\cites::check($city))
		{
			\dash\notif::error(T_("Invalid city"), 'city');
			return false;
		}

		// if(!$city)
		// {
		// 	\dash\notif::error(T_("City is required"), 'city');
		// 	return false;
		// }


		if(!$province && $city)
		{
			$province = \dash\utility\location\cites::get($city, 'province', 'province');
			if(!\dash\utility\location\provinces::check($province))
			{
				$province = null;
			}
		}


		if($country && !\dash\utility\location\countres::check($country))
		{
			\dash\notif::error(T_("Invalid country name"), 'country');
			return false;
		}

		$args                    = [];
		$args['mobile']          = $mobile;
		$args['gender']          = $gender;
		$args['email']           = $email;
		$args['birthday']        = $birthday;
		$args['firstname']       = $firstname;
		$args['lastname']        = $lastname;
		if($nationalcode)
		{
			$args['nationalcode']    = "$nationalcode";
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

		if($gender && $birthday && $firstname && $lastname && $father)
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
	 * ready data of user to load in api
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
				// case 'id':
				// case 'user_id':
					// if(isset($value))
					// {
					// 	$result[$key] = \dash\coding::encode($value);
					// }
					// else
					// {
					// 	$result[$key] = null;
					// }
					// break;

				case 'country':
					$result[$key] = $value;
					$result['country_name'] = \dash\utility\location\countres::get_localname($value, true);
					$result['location_string'][1] = $result['country_name'];
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

				case 'map':
					if($value && is_string($value))
					{
						$result[$key] = json_decode($value, true);
					}
					else
					{
						$result[$key] = $value;
					}
					break;

				default:
					$result[$key] = $value;
					break;
			}
		}
		ksort($result['location_string']);
		$result['location_string'] = array_filter($result['location_string']);
		$result['location_string'] = implode(" - ", $result['location_string']);

		return $result;
	}







	/**
	 * add new product
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args, $_option = [])
	{
		$default_option =
		[
			'debug' => true,
			'place' => null,
		];

		if(!is_array($_option))
		{
			$_option = [];
		}

		$_option = array_merge($default_option, $_option);

		\dash\app::variable($_args);

		// check args
		$args = self::check($_option);

		if(isset($args['nationalcode']))
		{
			$check_duplicate =
			[
				'nationalcode' => $args['nationalcode'],
				'limit'        => 1,
			];
			$check_duplicate = \lib\db\mokebusers::get($check_duplicate);
			if(isset($check_duplicate['id']))
			{
				\dash\notif::error("ثبت‌نام با این کد‌ملی قبلا با موفقیت انجام شده است. لطفا منتظر نتایج قرعه کشی باشید", 'nationalcode');
				return false;
			}
		}

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		$expire = self::get_expire($_option['place']);

		$args['position'] = self::get_position($_option['place']);
		$args['place_id'] = \dash\coding::decode($_option['place']);
		$args['expire']   = $expire;

		$id = \lib\db\mokebusers::insert($args);

		if($id)
		{
			if((intval($id) % 1000 ) === 0 )
			{
				\dash\log::set('karbala2SignupCounter', ['countall' => $id]);
			}

			if(isset($args['mobile']) && \dash\utility\filter::mobile($args['mobile']))
			{
				$is_user_signup = \dash\db\users::get_by_mobile($args['mobile']);
				$user_id = null;
				if(isset($is_user_signup['id']))
				{
					$user_id = $is_user_signup['id'];
				}
				else
				{
					$user_id = \dash\db\users::signup($args);
				}
				\dash\log::set('karbalaarbaeenUserSignup', ['code' => $id, 'to' => $user_id]);
			}
			else
			{
				\dash\log::set('karbalaarbaeenUserSignupWithoutmobile', ['code' => $id]);
			}
		}

		return true;
	}




	/**
	 * add new product
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function edit($_args, $_id)
	{

		\dash\app::variable($_args);

		// check args
		$args = self::check();

		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


		if(isset($args['nationalcode']))
		{
			$check_duplicate =
			[
				'nationalcode' => $args['nationalcode'],
				'limit'        => 1,
			];
			$check_duplicate = \lib\db\mokebusers::get($check_duplicate);

			if(isset($check_duplicate['id']))
			{
				if(intval($check_duplicate['id']) === intval($id))
				{

				}
				else
				{

					\dash\notif::error("ثبت‌نام با این کد‌ملی قبلا با موفقیت انجام شده است.", 'nationalcode');
					return false;
				}
			}
		}

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		if(!\dash\app::isset_request('mobile')) unset($args['mobile']);
		if(!\dash\app::isset_request('gender')) unset($args['gender']);
		if(!\dash\app::isset_request('email')) unset($args['email']);
		if(!\dash\app::isset_request('birthday')) unset($args['birthday']);
		if(!\dash\app::isset_request('firstname')) unset($args['firstname']);
		if(!\dash\app::isset_request('lastname')) unset($args['lastname']);
		if(!\dash\app::isset_request('nationalcode')) unset($args['nationalcode']);
		if(!\dash\app::isset_request('nationalcode')) unset($args['nationalcode']);
		if(!\dash\app::isset_request('father')) unset($args['father']);
		if(!\dash\app::isset_request('pasportcode')) unset($args['pasportcode']);
		if(!\dash\app::isset_request('pasportdate')) unset($args['pasportdate']);
		if(!\dash\app::isset_request('education')) unset($args['education']);
		if(!\dash\app::isset_request('educationcourse')) unset($args['educationcourse']);
		if(!\dash\app::isset_request('country')) unset($args['country']);
		if(!\dash\app::isset_request('province')) unset($args['province']);
		if(!\dash\app::isset_request('city')) unset($args['city']);
		if(!\dash\app::isset_request('homeaddress')) unset($args['homeaddress']);
		if(!\dash\app::isset_request('workaddress')) unset($args['workaddress']);
		if(!\dash\app::isset_request('arabiclang')) unset($args['arabiclang']);
		if(!\dash\app::isset_request('phone')) unset($args['phone']);
		if(!\dash\app::isset_request('displayname')) unset($args['displayname']);
		if(!\dash\app::isset_request('married')) unset($args['married']);
		if(!\dash\app::isset_request('zipcode')) unset($args['zipcode']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('job')) unset($args['job']);
		if(!\dash\app::isset_request('avatar')) unset($args['avatar']);
		if(!\dash\app::isset_request('nesbat')) unset($args['nesbat']);
		if(!\dash\app::isset_request('iscompleteprofile')) unset($args['iscompleteprofile']);


		$id = \lib\db\mokebusers::update($args, $id);

		return true;
	}

}
?>