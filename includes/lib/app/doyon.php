<?php
namespace lib\app;

class doyon
{
	public static $sort_field =
	[
		'title',
		'type',
		'count',
		'price',
		'priceone',
		'status',
		'datecreated',
	];

	public static function chart()
	{
		$now = date("Y-m-d");
		$lastYear = date("Y-m-d", strtotime("-1 year"));

		$get_chart = \lib\db\doyon::get_chart($now, $lastYear);

		if(!is_array($get_chart))
		{
			return false;
		}


		$data       = [];
		$categories = [];

		foreach ($get_chart as $key => $value)
		{
			$myDate = \dash\datetime::fit($value['date'], null, 'date');
			if(!in_array($myDate, $categories))
			{
				array_push($categories, $myDate);
			}



			$temp = null;
			if(isset($value['sumprice']))
			{
				$temp = floatval($value['sumprice']);
			}

			if(!isset($data[$value['type']]))
			{
				$data[$value['type']] = ['name' => T_($value['type']), 'data' => []];
			}

			$data[$value['type']]['data'][] = $temp;

		}
		$data                 = array_values($data);
		$result               = [];
		$result['categories'] = json_encode($categories, JSON_UNESCAPED_UNICODE);
		$result['data']       = json_encode($data, JSON_UNESCAPED_UNICODE);
		return $result;
	}

	public static function type_count($_args = null)
	{
		return \lib\db\doyon::type_count($_args);
	}


	public static function list($_string, $_args)
	{
		$search = \lib\db\doyon::search($_string, $_args);
		if(is_array($search))
		{
			$search = array_map(['self', 'ready'], $search);
		}
		return $search;
	}

	private static function ready($_data)
	{
		$result = [];
		if(!is_array($_data))
		{
			$_data = [];
		}

		foreach ($_data as $key => $value)
		{
			switch ($key)
			{

				default:
					$result[$key] = $value;
					break;
			}
		}

		return $result;
	}


	private static function get_file()
	{
		$get = [];
		$addr = root. '/includes/lib/doyon.json';
		if(is_file($addr))
		{
			$get = \dash\file::read($addr);
			$get = json_decode($get, true);
			if(!is_array($get))
			{
				$get = [];
			}
		}

		return $get;
	}


	public static function get_raw_list()
	{
		$list = self::get_file();
		return $list;
	}

	private static function setting()
	{
		$setting = self::get_file();
		if(isset($setting['setting']))
		{
			return $setting['setting'];
		}
		return false;
	}


	public static function get_my_list()
	{
		$record = \dash\session::get('doyon_list');
		if(!is_array($record))
		{
			$record = [];
		}
		return $record;
	}


	private static function add_record($_args)
	{
		$record = \dash\session::get('doyon_list');
		if(!is_array($record))
		{
			$record = [];
		}

		$fullname = \dash\app::request('fullname');
		if($fullname && mb_strlen($fullname) > 100)
		{
			$fullname = substr($fullname, 0, 99);
		}

		$mobile = \dash\app::request('mobile');

		$user_id = \dash\user::id();

		if($mobile)
		{
			$mobile = \dash\utility\filter::mobile($mobile);
			if(!$mobile)
			{
				\dash\notif::error(T_("Invalid mobile"), 'mobile');
				return false;
			}

			$user_detail = \dash\db\users::get_by_mobile($mobile);
			if(isset($user_detail['id']))
			{
				$user_id = $user_detail['id'];
			}
			else
			{
				$user_id = \dash\db\users::signup(['mobile' => $mobile, 'displayname' => $fullname]);
			}
		}

		$saheb = \dash\app::request('saheb');
		if($saheb && mb_strlen($saheb) > 100)
		{
			$saheb = substr($saheb, 0, 99);
		}

		$_args['db']['user_id']  = $user_id;
		$_args['db']['fullname'] = $fullname;
		$_args['db']['saheb']    = $saheb;

		$my_key = md5(json_encode($_args). '_'. rand(). '_'. time());

		$record[$my_key] = $_args;

		\dash\session::set('doyon_list', $record);
	}


	public static function add($_args)
	{
		\dash\app::variable($_args);

		$type = \dash\app::request('type');

		switch ($type)
		{
			case 'fetriye':
			case 'sadaqe':
			case 'mazalem':
			case 'kafarat':
			case 'namazqaza':
				return self::$type();
				break;

			case 'remove':
				return self::remove();
				break;


			case 'pay':
				return self::pay();
				break;

			default:
				\dash\notif::error(T_("Invalid type"));
				return false;
				break;
		}
	}


	public static function after_pay($_ids)
	{
		if(is_array($_ids))
		{
			\lib\db\doyon::set_pay($_ids);
			self::set_notif($_ids);
			\dash\session::set('doyon_list', null);
		}
	}


	private static function set_notif($_ids)
	{
		foreach ($_ids as $key => $value)
		{
			$load = \lib\db\doyon::get(['id' => $value, 'limit' => 1]);

			if(isset($load['type']))
			{
				if(!$load['user_id'])
				{
					continue;
				}

				switch ($load['type'])
				{

					case 'fetriye':
					case 'sadaqe':
					case 'mazalem':
					case 'kafarat':
					case 'namazqaza':
						\dash\log::set('doyon_'. $load['type'], ['to' => $load['user_id'], 'detail' => $load]);
						break;

					default:
						// nothing
						break;
				}
			}
		}
	}

	private static function pay()
	{
		$list = self::get_my_list();
		$insert = [];
		foreach ($list as $key => $value)
		{
			if(isset($value['db']))
			{
				$insert[] = $value['db'];
			}
		}

		if(empty($insert))
		{
			\dash\notif::error(T_("No record founded"));
			return false;
		}

		$sumprice = array_sum(array_column($insert, 'price'));

		if(!$sumprice)
		{
			\dash\notif::error(T_("No record founded"));
			return false;
		}

		\lib\db\doyon::multi_insert($insert);
		$final_fn_args = \dash\db\config::multi_insert_id($insert);

		$turn_back = \dash\url::that();

		$auto_go   = false;
		$auto_back = false;

		$msg_go = T_("Pay doyon :price toman", ['price' => \dash\utility\human::fitNumber($sumprice)]);

		$meta =
		[
			'turn_back'     => $turn_back,
			'user_id'       => \dash\user::id() ? \dash\user::id() : 'unverify',
			'amount'        => $sumprice,
			'final_fn'      => ['/lib/app/doyon', 'after_pay'],
			'final_fn_args' => $final_fn_args,
			'auto_go'       => $auto_go,
			'msg_go'        => $msg_go,
			'auto_back'     => $auto_back,
			'final_msg'     => true,
			'other_field'   =>
			[
				'hazinekard' => 'doyon',
			]
		];

		\dash\utility\pay\start::site($meta);
	}


	private static function remove()
	{
		$key = \dash\app::request('key');
		if(!$key)
		{
			\dash\notif::error(T_("Invalid key"));
			return false;
		}

		$list = self::get_my_list();
		if(array_key_exists($key, $list))
		{
			unset($list[$key]);
			\dash\session::set('doyon_list', $list);
			\dash\notif::ok(T_("Item deleted"));
		}
		else
		{
			\dash\notif::error(T_("Key not found"));
			return false;
		}
	}


	private static function fetriye()
	{
		$seyyed   = \dash\app::request('seyyed');
		if(!in_array($seyyed, ['aam','seyyed']))
		{
			\dash\notif::error(T_("Invalid seyyed or aam"));
			return false;
		}

		$qotqaleb = \dash\app::request('qotqaleb');

		if(!in_array($qotqaleb, ['gandom','berenj', 'berenjkhareji', 'other']))
		{
			\dash\notif::error(T_("Plese select one item of qotqaleb"));
			return false;
		}
		$is_other = false;
		$price = 0;
		if($qotqaleb === 'other')
		{
			$is_other = true;
			$price    = \dash\app::request('price');
			if(!$price)
			{
				\dash\notif::error(T_("Plese set price"), 'price');
				return false;
			}

			if(!is_numeric($price))
			{
				\dash\notif::error(T_("Plese set price as a number"), 'price');
				return false;
			}

			$price = abs(intval($price));
			if($price > 1E+9)
			{
				\dash\notif::error(T_("price is out of range"), 'price');
				return false;
			}
			$count = 1;
		}
		else
		{


			$count    = \dash\app::request('count');
			if(!$count)
			{
				\dash\notif::error(T_("Plese set count"), 'count');
				return false;
			}

			if(!is_numeric($count))
			{
				\dash\notif::error(T_("Plese set count as a number"), 'count');
				return false;
			}

			$count = abs(intval($count));
			if($count > 100)
			{
				\dash\notif::error(T_("Count is out of range, maximum 100"), 'count');
				return false;
			}
		}

		$setting = self::setting();
		if(isset($setting['fetriye'][$qotqaleb]['price']))
		{
			$price = intval($setting['fetriye'][$qotqaleb]['price']);
		}

		$qotqaleb_title = $qotqaleb;
		if(isset($setting['fetriye'][$qotqaleb]['title']))
		{
			$qotqaleb_title = $setting['fetriye'][$qotqaleb]['title'];
		}

		$sumprice = $count * $price;

		$myTitle = 'پرداخت فطریه';

		$add =
		[
			'db' =>
			[
				'seyyed'   => $seyyed === 'aam' ? null : 1,
				'title'    => $myTitle,
				'type'     => __FUNCTION__,
				'count'    => $count,
				'priceone' => $price,
				'price'    => $sumprice,
				'status'   => 'draft',
				'subtitle' => $qotqaleb_title,
			],
			'cat'      => $myTitle,
			'cat2'     => $seyyed === 'aam' ? '' : 'به سادات',
			'cat3'     => $is_other ? null : ' با قوت قالب ' . $qotqaleb_title,
			'count'    => $is_other ? null : ' برای  '.\dash\utility\human::fitNumber($count) . ' نفر',
			'price'    => $is_other ? null : ' هر نفر '. \dash\utility\human::fitNumber($price). ' تومان',
			'sum'      => $sumprice,
			'sumtitle' => \dash\utility\human::fitNumber($sumprice). ' تومان ',
		];

		return self::add_record($add);
	}


	private static function sadaqe()
	{
		$price    = \dash\app::request('price');
		if(!$price)
		{
			\dash\notif::error(T_("Plese set price"), 'price');
			return false;
		}

		if(!is_numeric($price))
		{
			\dash\notif::error(T_("Plese set price as a number"), 'price');
			return false;
		}

		$price = abs(intval($price));
		if($price > 1E+9)
		{
			\dash\notif::error(T_("Count is out of range"), 'price');
			return false;
		}

		$myTitle = 'پرداخت صدقه';

		$add =
		[
			'db' =>
			[
				'seyyed'   => null,
				'title'    => $myTitle,
				'type'     => __FUNCTION__,
				'count'    => null,
				'priceone' => null,
				'price'    => $price,
				'status'   => 'draft',
				'subtitle' => null,
			],
			'cat'      => $myTitle,
			'sum'      => $price,
			'sumtitle' => ' به مبلغ '. \dash\utility\human::fitNumber($price). ' تومان',
		];

		return self::add_record($add);
	}


	private static function mazalem()
	{
		$price    = \dash\app::request('price');
		if(!$price)
		{
			\dash\notif::error(T_("Plese set price"), 'price');
			return false;
		}

		if(!is_numeric($price))
		{
			\dash\notif::error(T_("Plese set price as a number"), 'price');
			return false;
		}

		$price = abs(intval($price));
		if($price > 1E+9)
		{
			\dash\notif::error(T_("Count is out of range"), 'price');
			return false;
		}

		$myTitle = 'پرداخت رد مظالم';

		$add =
		[
			'db' =>
			[
				'seyyed'   => null,
				'title'    => $myTitle,
				'type'     => __FUNCTION__,
				'count'    => null,
				'priceone' => null,
				'price'    => $price,
				'status'   => 'draft',
				'subtitle' => null,
			],
			'cat'      => $myTitle,
			'sum'      => $price,
			'sumtitle' => ' به مبلغ '. \dash\utility\human::fitNumber($price). ' تومان',
		];

		return self::add_record($add);

	}


	private static function kafarat()
	{
		// kafare
		$kafare = \dash\app::request('kafare');
		if(!in_array($kafare, ['roze_amd','roze_ozr','nazr','ahd','qasam']))
		{
			\dash\notif::error(T_("Invalid type"));
			return false;
		}


		$count    = \dash\app::request('count');
		if(!$count)
		{
			\dash\notif::error(T_("Plese set count"), 'count');
			return false;
		}

		if(!is_numeric($count))
		{
			\dash\notif::error(T_("Plese set count as a number"), 'count');
			return false;
		}

		$count = abs(intval($count));
		if($count > 1E+9)
		{
			\dash\notif::error(T_("Count is out of range"), 'count');
			return false;
		}

		$myTitle = 'کفاره';
		$setting = self::setting();
		if(isset($setting['kafarat'][$kafare]['title']))
		{
			$myTitle = $setting['kafarat'][$kafare]['title'];
		}


		$myUnit = 'مورد';

		if(isset($setting['kafarat'][$kafare]['unit']))
		{
			$myUnit = $setting['kafarat'][$kafare]['unit'];
		}

		$price = 0;
		if(isset($setting['kafarat'][$kafare]['price']))
		{
			$price = intval($setting['kafarat'][$kafare]['price']);
		}

		$mysum = $count * $price;

		$add =
		[
			'db' =>
			[
				'seyyed'   => null,
				'title'    => $myTitle,
				'type'     => __FUNCTION__,
				'count'    => $count,
				'priceone' => $price,
				'price'    => $mysum,
				'status'   => 'draft',
				'subtitle' => null,
			],
			'cat'      => $myTitle,
			'count'    => ' به تعداد  '.\dash\utility\human::fitNumber($count) . ' '. $myUnit,
			'price'    => ' هر '.  $myUnit. ' '.\dash\utility\human::fitNumber($price) . ' تومان',
			'sum'      => $mysum,
			'sumtitle' => ' به مبلغ '. \dash\utility\human::fitNumber($mysum). ' تومان',
		];

		return self::add_record($add);


	}


	private static function namazqaza()
	{
		// kafare
		$namazqaza = \dash\app::request('namazqaza');
		if(!in_array($namazqaza, ['namazqaza','rozeqaza']))
		{
			\dash\notif::error(T_("Invalid type"));
			return false;
		}


		$count    = \dash\app::request('count');
		if(!$count)
		{
			\dash\notif::error(T_("Plese set count"), 'count');
			return false;
		}

		if(!is_numeric($count))
		{
			\dash\notif::error(T_("Plese set count as a number"), 'count');
			return false;
		}

		$count = abs(intval($count));
		if($count > 1E+9)
		{
			\dash\notif::error(T_("Count is out of range"), 'count');
			return false;
		}

		$myTitle = 'کفاره';
		$setting = self::setting();
		if(isset($setting['namazqaza'][$namazqaza]['title']))
		{
			$myTitle = $setting['namazqaza'][$namazqaza]['title'];
		}


		$myUnit = 'مورد';

		if(isset($setting['namazqaza'][$namazqaza]['unit']))
		{
			$myUnit = $setting['namazqaza'][$namazqaza]['unit'];
		}

		$price = 0;
		if(isset($setting['namazqaza'][$namazqaza]['price']))
		{
			$price = intval($setting['namazqaza'][$namazqaza]['price']);
		}

		$mysum = $count * $price;

		$add =
		[
			'db' =>
			[
				'seyyed'   => null,
				'title'    => $myTitle,
				'type'     => __FUNCTION__,
				'count'    => $count,
				'priceone' => $price,
				'price'    => $mysum,
				'status'   => 'draft',
				'subtitle' => null,
			],
			'cat'      => $myTitle,
			'count'    => ' به تعداد  '.\dash\utility\human::fitNumber($count) . ' '. $myUnit,
			'price'    => ' هر '.  $myUnit. ' '.\dash\utility\human::fitNumber($price) . ' تومان',
			'sum'      => $mysum,
			'sumtitle' => ' به مبلغ '. \dash\utility\human::fitNumber($mysum). ' تومان',
		];

		return self::add_record($add);
	}
}
?>
