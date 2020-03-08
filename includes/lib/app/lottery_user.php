<?php
namespace lib\app;

class lottery_user
{

	public static function chart_province($_lottery_id)
	{
		$list = \lib\db\lottery_user::chart_province($_lottery_id);
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

	public static function chart_province_list($_lottery_id)
	{
		$list = \lib\db\lottery_user::chart_province($_lottery_id);
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

	public static function daily_chart($_lottery_id)
	{
		$result     = \lib\db\lottery_user::daily_chart($_lottery_id);
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

		$lottery_id = \dash\app::request('lottery_id');
		$load_lottery = \lib\app\syslottery::get($lottery_id);


		if(!$load_lottery || !isset($load_lottery['id']) || !isset($load_lottery['status']))
		{
			\dash\notif::error(T_("Invalid lottery"));
			return false;
		}

		if($load_lottery['status'] !== 'enable')
		{
			\dash\notif::error(T_("This lottery is not enable!"));
			return false;
		}

		$lottery_id = \dash\coding::decode($lottery_id);

		$isRequired =
		[
			'firstname'    => true,
			'lastname'     => true,
			'nationalcode' => true,
			'mobile'       => true,
			'gender'       => true,

			'father'       => false,
			'marital'      => false,
			'birthdate'    => false,
			'phone'        => false,
			'city'         => false,
			'address'      => false,
			'education'    => false,
			'imagefile'    => false,
			'videofile'    => false,
		];
		if(isset($load_lottery['requiredfield']))
		{
			$isRequired_temp = json_decode($load_lottery['requiredfield'], true);
			if(!is_array($isRequired_temp))
			{
				$isRequired_temp = [];
			}

			$isRequired = array_merge($isRequired, $isRequired_temp);
		}

		$gender = \dash\app::request('gender');
		if($gender && !in_array($gender, ['male', 'female']))
		{
			\dash\notif::error(T_("Invalid arguments gender"), 'gender');
			return false;
		}

		if($isRequired['gender'])
		{
			if(!$gender)
			{
				\dash\notif::error(T_("Plese set your gender"), 'gender');
				return false;
			}
		}

		$mobile = \dash\app::request('mobile');
		$mobile = \dash\utility\filter::mobile($mobile);

		if($isRequired['mobile'])
		{
			if(!$mobile)
			{
				\dash\notif::error(T_("Invalid mobile"), 'mobile');
				return false;
			}
		}


		$email = \dash\app::request('email');
		if($email && mb_strlen($email) > 70)
		{
			\dash\notif::error(T_("Invalid arguments email"), 'email');
			return false;
		}

		$birthday = \dash\app::request('birthday');
		if($isRequired['birthdate'])
		{
			if(!$birthday)
			{
				\dash\notif::error(T_("Birthday is required"), 'birthday');
				return false;
			}
		}

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
		if($isRequired['father'])
		{
			if(!$father)
			{
				\dash\notif::error(T_("Father name is required"), 'father');
				return false;
			}
		}

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

		if($isRequired['address'])
		{
			if(!$homeaddress)
			{
				\dash\notif::error(T_("Address is required"), 'homeaddress');
				return false;
			}
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

		if($isRequired['phone'])
		{
			if(!$phone)
			{
				\dash\notif::error(T_("Phone is required"), 'phone');
				return false;
			}
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

		if($isRequired['marital'])
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

		if($isRequired['city'])
		{

			if(!$city)
			{
				\dash\notif::error(T_("City is required"), 'city');
				return false;
			}

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


		$imagefile1 = \dash\app::request('imagefile1');
		$imagefile2 = \dash\app::request('imagefile2');
		$imagefile3 = \dash\app::request('imagefile3');
		$imagefile4 = \dash\app::request('imagefile4');
		$imagefile5 = \dash\app::request('imagefile5');

		// if($isRequired['imagefile'])
		// {
		// 	if(!$imagefile1 && !$imagefile2 && !$imagefile3 && !$imagefile4 && !$imagefile5)
		// 	{
		// 		\dash\notif::error(T_("Please upload an image file"));
		// 		return false;
		// 	}
		// }

		$videofile1 = \dash\app::request('videofile1');
		$videofile2 = \dash\app::request('videofile2');
		$videofile3 = \dash\app::request('videofile3');
		$videofile4 = \dash\app::request('videofile4');
		// $videofile5 = \dash\app::request('videofile5');

		if($isRequired['videofile'] || $isRequired['imagefile'])
		{
			if(!$videofile1 && !$videofile2 && !$videofile3 && !$videofile4 && !$imagefile1 && !$imagefile2 && !$imagefile3 && !$imagefile4 && !$imagefile5)
			{
				\dash\notif::error("لطفا فایلی را بارگذاری کنید");
				return false;
			}
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
		$args['lottery_id']          = $lottery_id;
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


		$args['imagefile1'] = $imagefile1;
		$args['imagefile2'] = $imagefile2;
		$args['imagefile3'] = $imagefile3;
		$args['imagefile4'] = $imagefile4;
		$args['imagefile5'] = $imagefile5;
		$args['videofile1'] = $videofile1;
		$args['videofile2'] = $videofile2;
		$args['videofile3'] = $videofile3;
		$args['videofile4'] = $videofile4;
		// $args['videofile5'] = $videofile5;

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
				'lottery_id'   => $args['lottery_id'],
				'limit'        => 1,
			];
			$check_duplicate = \lib\db\lottery_user::get($check_duplicate);
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



		$id = \lib\db\lottery_user::insert($args);

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
					unset($args['lottery_id']);
					unset($args['imagefile1']);
					unset($args['imagefile2']);
					unset($args['imagefile3']);
					unset($args['imagefile4']);
					unset($args['imagefile5']);
					unset($args['videofile1']);
					unset($args['videofile2']);
					unset($args['videofile3']);
					unset($args['videofile4']);
					unset($args['videofile5']);

					$user_id = \dash\db\users::signup($args);
				}
				\dash\log::set('lotetry', ['code' => $id, 'to' => $user_id]);
			}
			else
			{
				\dash\log::set('lotetryWithoutmobile', ['code' => $id]);
			}
		}

		return true;
	}

}
?>