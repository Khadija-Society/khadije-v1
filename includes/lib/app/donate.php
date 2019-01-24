<?php
namespace lib\app;

class donate
{
	public static $way_key = 'hazinekard_list';

	public static function option_key_type($_type)
	{
		if($_type === 'donate')
		{
			return self::$way_key;
		}
		elseif($_type === 'sms')
		{
			return 'template_sms';
		}
	}

	public static function sms_success($_amount = null)
	{

		$mobile = \dash\session::get('temp_mobile_sms_verify_payment');
		\dash\session::set('temp_mobile_sms_verify_payment', null);
		if($mobile)
		{
			$msg = '';
			if($_amount)
			{
				$_amount = \dash\utility\convert::to_fa_number($_amount);
				$msg .= "نذر شما قبول\n";
				$msg .= "مبلغ ". $_amount. " تومان دریافت شد";
			}
			else
			{
				$msg .= "نذر شما قبول\n";
				$msg .= "موفق باشید";
			}

			\dash\utility\sms::send($mobile, $msg);
		}
	}

	public static function remove_way($_way, $_type = 'donate')
	{
		$_way = trim($_way);

		$old = self::way_list($_type);
		if(array_search($_way, $old) === false)
		{
			\dash\notif::error(T_("This :way is not in your list!", ['way' => T_($_type)]));
			return false;
		}

		unset($old[array_search($_way, $old)]);

		self::set_way($old, true, $_type);
		return true;

	}

	public static function way_list($_type = 'donate')
	{
		$list = \lib\app\need::list('donate');
		if(!is_array($list))
		{
			$list = [];
		}
		return array_column($list, 'title');


		// $key = self::option_key_type($_type);

		// $list = \dash\db\options::get(['key' => $key, 'limit' => 1]);

		// $way_list = [];

		// if(isset($list['meta']))
		// {
		// 	if(is_array($list['meta']))
		// 	{
		// 		$way_list = $list['meta'];
		// 	}
		// 	else
		// 	{
		// 		$way_list = json_decode($list['meta']);
		// 	}
		// }

		// if(!is_array($way_list))
		// {
		// 	$way_list = [];
		// }
		// return $way_list;
	}


	public static function set_way($_way, $_set_all_way = false, $_type = 'donate')
	{
		if(!$_set_all_way)
		{
			$_way = trim($_way);

			if(!$_way)
			{
				\dash\notif::error(T_("Please set :way", ['way' => T_($_type)]), 'way');
				return false;
			}

			if(mb_strlen($_way) > 500)
			{
				\dash\notif::error(T_("Please set value less than 500 character"), 'way');
				return false;
			}
		}

		$key = self::option_key_type($_type);

		$list = \dash\db\options::get(['key' => $key, 'limit' => 1]);

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
				\dash\notif::error(T_("Duplicate :way", ['way' => T_($_type)]), 'way');
				return false;
			}

			array_push($way_list, $_way);
		}

		$meta = json_encode($way_list, JSON_UNESCAPED_UNICODE);

		if($update)
		{
			\dash\db\options::update(['meta' => $meta], $list['id']);
		}
		else
		{
			$insert_args =
			[
				'key'  => $key,
				'meta' => $meta,
			];
			\dash\db\options::insert($insert_args);
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
				'input' => \dash\app::request(),
			]
		];

		$name = \dash\app::request('name');
		$name = trim($name);
		if($name && mb_strlen($name) >= 500)
		{
			// \dash\app::log('api:product:name:max:lenght', \dash\user::id(), $log_meta);
			if($_option['debug']) \dash\notif::error(T_("Product name must be less than 500 character"), 'name');
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
		\dash\app::variable($_args);

		if(\dash\app::request('username'))
		{
			\dash\notif::error(T_("Whate are you doing?"));
			return false;
		}

		$niyat = \dash\app::request('niyat');
		$niyat = trim($niyat);
		if(mb_strlen($niyat) > 150)
		{
			\dash\notif::error(T_("Please set niyat less than 150 character"), 'niyat');
			return false;
		}

		$way = \dash\app::request('way');
		$way = trim($way);
		if($way && !in_array($way, \lib\app\donate::way_list()))
		{
			\dash\notif::error(T_("Please set a valid way"), 'way');
			return false;
		}

		$fullname = \dash\app::request('fullname');
		$fullname = trim($fullname);
		if(mb_strlen($fullname) > 150)
		{
			\dash\notif::error(T_("Please set fullname less than 150 character"), 'fullname');
			return false;
		}

		$doners = \dash\app::request('doners');
		$doners = $doners ? 1 : 0;


		$email = \dash\app::request('email');
		$email = trim($email);
		if(mb_strlen($email) > 90)
		{
			\dash\notif::error(T_("Please set email less than 90 character"), 'email');
			return false;
		}

		$mobile = \dash\app::request('mobile');
		$mobile = trim($mobile);
		if($mobile && !\dash\utility\filter::mobile($mobile))
		{
			\dash\notif::error(T_("Please set a valid mobile number"), 'mobile');
			return false;
		}

		if($mobile)
		{
			$mobile = \dash\utility\filter::mobile($mobile);
		}

		$amount = \dash\app::request('amount');
		if(!$amount || !is_numeric($amount))
		{
			\dash\notif::error(T_("Please set a valid amount number"), 'amount');
			return false;
		}

		$user_id = \dash\user::id();

		if(!\dash\user::id())
		{
			if($mobile)
			{
				$check_user_mobile = \dash\db\users::get_by_mobile($mobile);
				if(isset($check_user_mobile['id']))
				{
					$user_id = $check_user_mobile['id'];
				}
				else
				{
					if($email)
					{
						$check_user_email = \dash\db\users::get_by_email($email);
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
							$user_id = \dash\db\users::signup($signup);
						}
					}
					else
					{
						$signup =
						[
							'mobile'      => $mobile,
							'displayname' => $fullname,
						];
						$user_id = \dash\db\users::signup($signup);
					}
				}
			}
			elseif($email)
			{
				$check_user_email = \dash\db\users::get_by_email($email);
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
					$user_id = \dash\db\users::signup($signup);
				}
			}
			else
			{
				$user_id = 'unverify';
			}
		}

		if($mobile && \dash\utility\filter::mobile($mobile))
		{
			\dash\session::set('temp_mobile_sms_verify_payment', $mobile);
		}
		elseif(\dash\user::id() && \dash\user::detail('mobile') && \dash\utility\filter::mobile(\dash\user::detail('mobile')))
		{
			\dash\session::set('temp_mobile_sms_verify_payment', \dash\user::detail('mobile'));
		}


		if(\dash\app::request('manuall') === 'on')
		{
			$transaction_set =
	        [
				'caller'     => 'manually',
				'title'      => T_("Pay donate"),
				'user_id'    => $user_id,
				'minus'      => null,
				'plus'       => \dash\app::request('amount'),
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

	        $insert = \dash\db\transactions::set($transaction_set);

	        if($insert)
	        {
	        	\dash\notif::ok(T_("Transaction successfully inserted"));
	        }
	        else
	        {
	        	\dash\notif::error(T_("Can not add transactions"));
	        }
		}
		else
		{
			if(isset($_args['turn_back']))
			{
				$turn_back = $_args['turn_back'];
			}
			else
			{
				$turn_back = \dash\url::this();
			}

			$auto_go   = false;
			if(array_key_exists('auto_go', $_args))
			{
				$auto_go   = $_args['auto_go'];
			}

			$auto_back = false;

			if(\dash\request::is_android())
			{
				$auto_go   = false;
				$auto_back = false;
				$turn_back = 'khadije://'. $turn_back;

				\dash\redirect::to('externalweb:https://khadije.com');
				return;
				if($user_id === 'unverify')
				{
					$user_id = \dash\user::app_id();
					if(!$user_id)
					{
						$user_id = 'unverify';
					}
				}
			}


			$msg_go = T_("Pay donate :price toman", ['price' => \dash\utility\human::fitNumber(\dash\app::request('amount'))]);

			if($way)
			{
				$msg_go .= ' ('. $way. ') ';
			}


			$meta =
			[
				'turn_back' => $turn_back,
				'user_id'   => $user_id,
				'amount'    => \dash\app::request('amount'),
				'final_fn'  => ['/content/donate/view', 'after_pay'],
				'auto_go'   => $auto_go,
				'msg_go'    => $msg_go,
				'auto_back' => $auto_back,
				'final_msg' => true,
				'other_field' =>
				[
					'hazinekard' => $way,
					'niyat'      => $niyat,
					'fullname'   => $fullname,
					'donate'     => 'cash',
					'doners'     => $doners,
				]
			];

			\dash\utility\pay\start::site($meta);

		}
	}
}
?>