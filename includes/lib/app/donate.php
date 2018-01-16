<?php
namespace lib\app;

class donate
{
	public static $way_key = 'hazinekard_list';

	public static function sms_success()
	{
		$mobile = \lib\session::get('temp_mobile_sms_verify_payment');
		\lib\session::set('temp_mobile_sms_verify_payment', null);
		if($mobile)
		{
			\lib\utility\sms::send($mobile, "نذر شما قبول. موفق باشید");
		}
	}

	public static function remove_way($_way)
	{
		$_way = trim($_way);

		$old = self::way_list();
		if(array_search($_way, $old) === false)
		{
			\lib\debug::error(T_("This way is not in your list!"));
			return false;
		}
		unset($old[array_search($_way, $old)]);

		self::set_way($old, true);
		return true;

	}

	public static function way_list()
	{
		$list = \lib\db\options::get(['key' => self::$way_key, 'limit' => 1]);

		$way_list = [];

		if(isset($list['meta']))
		{
			if(is_array($list['meta']))
			{
				$way_list = $list['meta'];
			}
			else
			{
				$way_list = json_decode($list['meta']);
			}
		}

		if(!is_array($way_list))
		{
			$way_list = [];
		}
		return $way_list;
	}


	public static function set_way($_way, $_set_all_way = false)
	{
		if(!$_set_all_way)
		{
			$_way = trim($_way);

			if(!$_way)
			{
				\lib\debug::error(T_("Please set way"), 'way');
				return false;
			}

			if(mb_strlen($_way) > 150)
			{
				\lib\debug::error(T_("Please set way less than 150 character"), 'way');
				return false;
			}
		}

		$key = self::$way_key;

		$list = \lib\db\options::get(['key' => $key, 'limit' => 1]);

		$update = false;

		if(isset($list['id']))
		{
			$update = true;
		}

		$way_list = [];

		if($_set_all_way)
		{
			$way_list = $_way;
		}
		else
		{
			if(isset($list['meta']))
			{
				if(is_array($list['meta']))
				{
					$way_list = $list['meta'];
				}
				elseif(substr($list['meta'], 0,1) === '[')
				{
					$way_list = json_decode($list['meta']);
				}
				else
				{
					$way_list = [];
				}
			}

			if(!is_array($way_list))
			{
				$way_list = [];
			}

			if(in_array($_way, $way_list))
			{
				\lib\debug::error(T_("Duplicate way"), 'way');
				return false;
			}

			array_push($way_list, $_way);
		}

		$meta = json_encode($way_list, JSON_UNESCAPED_UNICODE);

		if($update)
		{
			\lib\db\options::update(['meta' => $meta], $list['id']);
		}
		else
		{
			$insert_args =
			[
				'key'  => $key,
				'meta' => $meta,
			];
			\lib\db\options::insert($insert_args);
		}

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

		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\app::request(),
			]
		];

		$name = \lib\app::request('name');
		$name = trim($name);
		if($name && mb_strlen($name) >= 500)
		{
			// \lib\app::log('api:product:name:max:lenght', \lib\user::id(), $log_meta);
			if($_option['debug']) debug::error(T_("Product name must be less than 500 character"), 'name');
			return false;
		}

		$args                    = [];
		$args['title']           = $title;

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


	/**
	 * add new product
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args, $_option = [])
	{
		\lib\app::variable($_args);

		if(\lib\app::request('username'))
		{
			\lib\debug::error(T_("Whate are you doing?"));
			return false;
		}

		$niyat = \lib\app::request('niyat');
		$niyat = trim($niyat);
		if(mb_strlen($niyat) > 150)
		{
			\lib\debug::error(T_("Please set niyat less than 150 character"), 'niyat');
			return false;
		}

		$way = \lib\app::request('way');
		$way = trim($way);
		if($way && !in_array($way, \lib\app\donate::way_list()))
		{
			\lib\debug::error(T_("Please set a valid way"), 'way');
			return false;
		}

		$fullname = \lib\app::request('fullname');
		$fullname = trim($fullname);
		if(mb_strlen($fullname) > 150)
		{
			\lib\debug::error(T_("Please set fullname less than 150 character"), 'fullname');
			return false;
		}

		$doners = \lib\app::request('doners');
		$doners = $doners ? 1 : 0;


		$email = \lib\app::request('email');
		$email = trim($email);
		if(mb_strlen($email) > 90)
		{
			\lib\debug::error(T_("Please set email less than 90 character"), 'email');
			return false;
		}

		$mobile = \lib\app::request('mobile');
		$mobile = trim($mobile);
		if($mobile && !\lib\utility\filter::mobile($mobile))
		{
			\lib\debug::error(T_("Please set a valid mobile number"), 'mobile');
			return false;
		}

		if($mobile)
		{
			$mobile = \lib\utility\filter::mobile($mobile);
		}

		$amount = \lib\app::request('amount');
		if(!$amount || !is_numeric($amount))
		{
			\lib\debug::error(T_("Please set a valid amount number"), 'amount');
			return false;
		}

		$user_id = \lib\user::id();

		if(!\lib\user::id())
		{
			if($mobile)
			{
				$check_user_mobile = \lib\db\users::get_by_mobile($mobile);
				if(isset($check_user_mobile['id']))
				{
					$user_id = $check_user_mobile['id'];
				}
				else
				{
					if($email)
					{
						$check_user_email = \lib\db\users::get_by_email($email);
						if(isset($check_user_email['id']))
						{
							$user_id = $check_user_email['id'];
						}
						else
						{
							$signup =
							[
								'email'      => $email,
								'displayname' => $fullname,
							];
							$user_id = \lib\db\users::signup($signup);
						}
					}
					else
					{
						$signup =
						[
							'mobile'      => $mobile,
							'displayname' => $fullname,
						];
						$user_id = \lib\db\users::signup($signup);
					}
				}
			}
			elseif($email)
			{
				$check_user_email = \lib\db\users::get_by_email($email);
				if(isset($check_user_email['id']))
				{
					$user_id = $check_user_email['id'];
				}
				else
				{
					$signup =
					[
						'email'      => $email,
						'displayname' => $fullname,
					];
					$user_id = \lib\db\users::signup($signup);
				}
			}
			else
			{
				$user_id = 'unverify';
			}
		}

		if($mobile && \lib\utility\filter::mobile($mobile))
		{
			\lib\session::set('temp_mobile_sms_verify_payment', $mobile);
		}
		elseif(\lib\user::id() && \lib\user::detail('mobile') && \lib\utility\filter::mobile(\lib\user::detail('mobile')))
		{
			\lib\session::set('temp_mobile_sms_verify_payment', \lib\user::detail('mobile'));
		}


		$meta =
		[
			'turn_back'   => \lib\url::full(),
			'other_field' =>
			[
				'hazinekard' => $way,
				'niyat'      => $niyat,
				'fullname'   => $fullname,
				'donate'     => 'cash',
				'doners'     => $doners,
			]
		];

		if(\lib\app::request('manuall') === 'on')
		{
			$transaction_set =
	        [
				'caller'     => 'manually',
				'title'      => T_("Pay donate"),
				'user_id'    => $user_id,
				'minus'      => null,
				'plus'       => \lib\app::request('amount'),
				'verify'     => 1,
				'dateverify' => time(),
				'type'       => 'money',
				'unit'       => 'toman',
				'date'       => date("Y-m-d H:i:s"),
				'hazinekard' => $way,
				'niyat'      => $niyat,
				'fullname'   => $fullname,
				'donate'     => 'cash',
				'doners'     => $doners,
	        ];

	        $insert = \lib\db\transactions::set($transaction_set);

	        if($insert)
	        {
	        	\lib\debug::true(T_("Transaction successfully inserted"));
	        }
	        else
	        {
	        	\lib\debug::error(T_("Can not add transactions"));
	        }
		}
		else
		{
			\lib\utility\payment\pay::start($user_id, 'zarinpal', \lib\app::request('amount'), $meta);
		}
	}
}
?>