<?php
namespace lib\app;

class doyon
{
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
			\dash\session::set('doyon_list', null);
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
			\dash\notif::ok(T_("Record removed"));
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

		if(!in_array($qotqaleb, ['gandom','berenj', 'berenjkhareji']))
		{
			\dash\notif::error(T_("Plese select one item of qotqaleb"));
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
		if($count > 100)
		{
			\dash\notif::error(T_("Count is out of range, maximum 100"), 'count');
			return false;
		}

		$setting = self::setting();
		$price = 0;
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
				'user_id'  => \dash\user::id(),
			],
			'cat'      => $myTitle,
			'cat2'     => $seyyed === 'aam' ? '' : 'به سادات',
			'cat3'     => ' با قوت قالب ' . $qotqaleb_title,
			'count'    => ' برای  '.\dash\utility\human::fitNumber($count) . ' نفر',
			'price'    => ' هر نفر '. \dash\utility\human::fitNumber($price). ' تومان',
			'sum'      => $sumprice,
			'sumtitle' => 'مجموع '.  \dash\utility\human::fitNumber($sumprice). ' تومان ',
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
				'user_id'  => \dash\user::id(),
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
				'user_id'  => \dash\user::id(),
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
	}


	private static function namazqaza()
	{
		// namaz_roze_qaza
	}


}
?>
