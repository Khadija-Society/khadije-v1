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


			default:
				\dash\notif::error(T_("Invalid type"));
				return false;
				break;
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

		if(!in_array($qotqaleb, ['gandom','berenj']))
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

		$add =
		[
			'cat'   => 'فطریه',
			'cat2'  => $seyyed,
			'cat3'  => $qotqaleb,
			'count' => $count,
			'price' => $count,
			'sum'   => $count,
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
		if($price > 100)
		{
			\dash\notif::error(T_("Count is out of range, maximum 100"), 'price');
			return false;
		}


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
		if($price > 100)
		{
			\dash\notif::error(T_("Count is out of range, maximum 100"), 'price');
			return false;
		}

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
