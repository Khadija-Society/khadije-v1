<?php
namespace lib\app\platoon;

/**
 * Class for sms.
 */
class tools
{
	private static $locked_on = [];


	public static function list()
	{
		$list = [];

		$list[] =
		[
			'title'   => 'حاج آقا ثباتی',
			'avatar'  => 'https://dl.talambar.ir/1/59-7573ab1a3ad56a0abac913d0f00701fa.jpg',
			'mobile'  => '989127522690', // sobati
			'platoon' => '1',
		];

		$list[] =
		[
			'title'   => 'آستان مقدس',
			'avatar'  => 'https://qhkarimeh.ir/enterprise/qhkarimeh/images/logo.png',
			'mobile'  => '989123511113', // haram
			'platoon' => '2',
		];

		return $list;
	}


	public static function lock($_mobile)
	{
		$get = self::get($_mobile);
		if($get)
		{
			self::$locked_on = $get;
		}
	}

	public static function get_current_detail()
	{
		return self::$locked_on;
	}


	public static function get_index_locked()
	{
		if(isset(self::$locked_on['platoon']))
		{
			return self::$locked_on['platoon'];
		}
		return null;
	}


	public static function get($_mobile)
	{
		$list = self::list();

		foreach ($list as $key => $value)
		{
			if(isset($value['mobile']) && $value['mobile'] === $_mobile)
			{
				return $value;
			}
		}

		return [];
	}


	public static function get_index($_mobile)
	{
		$get = self::get($_mobile);

		if(isset($get['platoon']))
		{
			return $get['platoon'];
		}
		return null;
	}

}
?>