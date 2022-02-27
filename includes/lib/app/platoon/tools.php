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
			'title'             => 'موسسه حضرت خدیجه',
			'avatar'            => 'https://khadije.com/static/images/logo.png',
			'mobile'            => '989127522690', // sobati
			'platoon'           => '1',
			'linenumber'        => null,
			'kavenegar_api_key' => '52614F494433704634702B674477473754644D4D722B6A4C447371794F4E6371',
		];

		$list[] =
		[
			'title'             => 'شماره جدید موسسه',
			'avatar'            => 'https://khadije.com/static/images/logo.png',
			'mobile'            => '989101571711', // khadije 2
			'platoon'           => '1',
			'linenumber'        => null,
			'kavenegar_api_key' => '52614F494433704634702B674477473754644D4D722B6A4C447371794F4E6371',
		];


		$list[] =
		[
			'title'             => 'پنل پیامک',
			'avatar'            => 'https://khadije.com/static/images/logo.png',
			'mobile'            => '10006121', // sms panel
			'platoon'           => '4',
			'linenumber'        => null,
			'force_send_by_sms_panel'        => true,
			'kavenegar_api_key' => '52614F494433704634702B674477473754644D4D722B6A4C447371794F4E6371',
		];


		// $list[] =
		// [
		// 	'title'             => 'آستان مقدس',
		// 	'avatar'            => 'https://qhkarimeh.ir/enterprise/qhkarimeh/images/logo.png',
		// 	'mobile'            => '989123511113', // haram
		// 	'platoon'           => '2',
		// 	'linenumber'        => '10009918',
		// 	'kavenegar_api_key' => '4D354A6E554459773958377043735876312B6A385966704B755638485A33576F',
		// ];

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


	public static function force_send_by_sms_panel()
	{
		$get_index_locked = self::get_index_locked();
		if($get_index_locked)
		{
			$load_platoon = self::get_by_platoon($get_index_locked);

			if(a($load_platoon, 'force_send_by_sms_panel'))
			{
				return true;
			}
		}

		return false;
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



	public static function get_by_platoon($_platoon)
	{
		$list = self::list();

		foreach ($list as $key => $value)
		{
			if(isset($value['platoon']) && intval($value['platoon']) === intval($_platoon))
			{
				return $value;
			}
		}

		return null;
	}

}
?>