<?php
namespace lib\app;

class karbalauser
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


		$gender = \dash\app::request('gender');
		if($gender && !in_array($gender, ['male', 'female']))
		{
			\dash\notif::error(T_("Invalid arguments gender"), 'gender');
			return false;
		}

		if(\dash\app::isset_request('gender') && !$gender)
		{
			\dash\notif::error(T_("Plese set your gender"), 'gender');
			return false;
		}

		$mobile = \dash\app::request('mobile');
		$mobile = \dash\utility\filter::mobile($mobile);

		if(!$mobile)
		{
			\dash\notif::error(T_("Invalid mobile"), 'mobile');
			return false;
		}


		$email = \dash\app::request('email');
		if($email && mb_strlen($email) > 70)
		{
			\dash\notif::error(T_("Invalid arguments email"), 'email');
			return false;
		}

		$birthday = \dash\app::request('birthday');
		if(\dash\app::isset_request('birthday') && $birthday)
		{

			$birthday = \dash\date::birthdate($birthday, true);

			if($birthday === false)
			{
				return false;
			}
		}

		$firstname = \dash\app::request('firstname');

		if(!$firstname)
		{
			\dash\notif::error(T_("First name is required"), 'name');
			return false;
		}

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

		if(!$lastname)
		{
			\dash\notif::error(T_("Last name is required"), 'lastName');
			return false;
		}

		$nationalcode = \dash\app::request('nationalcode');
		$pasportcode = \dash\app::request('pasportcode');

		if(\dash\app::isset_request('nationalcode') || \dash\app::isset_request('pasportcode'))
		{
			if(!$nationalcode)
			{
				\dash\notif::error(T_("National code or pasportcode code is required"), ['nationalcode', 'pasportcode']);
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

		if(\dash\app::isset_request('married'))
		{
			if(!$married)
			{
				\dash\notif::error(T_("Plese set your married"), 'married');
				return false;
			}
		}

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
						$result[$key] = \dash\coding::encode($value);
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
			$check_duplicate = \lib\db\karbalausers::get($check_duplicate);
			if(isset($check_duplicate['id']))
			{
				\dash\notif::error(T_("This users signup before"), 'nationalcode');
				return false;
			}
		}

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		// if(!\dash\app::isset_request('avatar'))         unset($args['avatar']);
		// if(!\dash\app::isset_request('gender')) 		unset($args['gender']);
		// if(!\dash\app::isset_request('email')) 			unset($args['email']);
		// if(!\dash\app::isset_request('birthday')) 		unset($args['birthday']);
		// if(!\dash\app::isset_request('firstname')) 		unset($args['firstname']);
		// if(!\dash\app::isset_request('lastname')) 		unset($args['lastname']);
		// if(!\dash\app::isset_request('nationalcode')) 	unset($args['nationalcode']);
		// if(!\dash\app::isset_request('nationalcode')) 	unset($args['nationalcode']);
		// if(!\dash\app::isset_request('father')) 		unset($args['father']);
		// if(!\dash\app::isset_request('pasportcode')) 	unset($args['pasportcode']);
		// if(!\dash\app::isset_request('pasportdate')) 	unset($args['pasportdate']);
		// if(!\dash\app::isset_request('education')) 		unset($args['education']);
		// if(!\dash\app::isset_request('educationcourse')) unset($args['educationcourse']);
		// // if(!\dash\app::isset_request('country')) 		unset($args['country']);
		// // if(!\dash\app::isset_request('province')) 		unset($args['province']);
		// if(!\dash\app::isset_request('city')) 			unset($args['city']);
		// if(!\dash\app::isset_request('homeaddress')) 	unset($args['homeaddress']);
		// if(!\dash\app::isset_request('workaddress')) 	unset($args['workaddress']);
		// if(!\dash\app::isset_request('arabiclang')) 	unset($args['arabiclang']);
		// if(!\dash\app::isset_request('phone')) 			unset($args['phone']);
		// if(!\dash\app::isset_request('displayname')) 	unset($args['displayname']);
		// if(!\dash\app::isset_request('married')) 		unset($args['married']);
		// if(!\dash\app::isset_request('zipcode')) 		unset($args['zipcode']);
		// if(!\dash\app::isset_request('desc')) 			unset($args['desc']);
		// if(!\dash\app::isset_request('job')) 			unset($args['job']);
		// if(!\dash\app::isset_request('nesbat')) 		unset($args['nesbat']);


		$id = \lib\db\karbalausers::insert($args);

		if($id)
		{
			\dash\log::set('karbalaUserSignup', ['code' => $id]);
		}

		return true;
	}

}
?>