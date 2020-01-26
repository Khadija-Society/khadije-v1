<?php
namespace lib\app;

class karbalasetting
{
	public static function stat()
	{

		$result = [];

		$get_option_record =
		[
			'cat'   => 'stat_place_manual',
		];

		$manula_result = \dash\db\options::get($get_option_record);
		$manual = [];
		if(is_array($manula_result))
		{
			foreach ($manula_result as $key => $value)
			{
				$meta = [];
				if(isset($value['meta']) && is_string($value['meta']))
				{
					$meta = json_decode($value['meta'], true) ;
				}

				$temp           = [];
				$temp['id']     = isset($value['id']) ? $value['id'] : null;
				$temp['city']   = isset($meta['city']) ? $meta['city'] : null;
				$temp['status'] = isset($meta['status']) ? $meta['status'] : null;
				$temp['count']  = isset($meta['count']) ? $meta['count'] : null;
				$temp['desc']   = isset($meta['desc']) ? $meta['desc'] : null;

				$manual[] = $temp;
			}
		}


		$gone_group_trip = \lib\db\karbalasetting::gone_group_trip();
		foreach ($gone_group_trip as $key => $value)
		{
			if($value['type'] === 'family')
			{
				$result['gone']["تشرف انفرادی و خانوادگی"][$value['place']] = $value['count'];
			}

			if($value['type'] === 'group')
			{
				$result['gone']["تشرف کاروانی"][$value['place']] = $value['count'];
			}
		}

		$signup_group_trip = \lib\db\karbalasetting::signup_group_trip();
		foreach ($signup_group_trip as $key => $value)
		{
			if($value['type'] === 'family')
			{
				$result['signup']["تشرف انفرادی و خانوادگی"][$value['place']] = $value['count'];
			}

			if($value['type'] === 'group')
			{
				$result['signup']["تشرف کاروانی"][$value['place']] = $value['count'];
			}
		}

		$count_signup_samtekhoda = \lib\db\karbalasetting::count_signup_samtekhoda();
		$result['signup']["برنامه سمت خدا"]["karbala"] = $count_signup_samtekhoda;

		$count_signup_koyemohebbat = \lib\db\karbalasetting::count_signup_koyemohebbat();
		$result['signup']["برنامه کوی محبت"]["karbala"] = $count_signup_koyemohebbat;

		$mokeb = \lib\db\karbalasetting::count_signup_mokeb();
		foreach ($mokeb as $key => $value)
		{
			$result['signup']["موکب خدیجه"][$key] = $value;
			$result['gone']["موکب خدیجه"][$key] = $value;
		}

		foreach ($manual as $key => $value)
		{
			if(isset($value['status']) && isset($value['city']))
			{
				if($value['status'] === 'gone')
				{
					$result['gone']["آمار گذشته و غیر سیستمی"][$value['city']] = $value['count'];
				}

				if($value['status'] === 'signup')
				{
					$result['signup']["آمار گذشته و غیر سیستمی"][$value['city']] = $value['count'];
				}
			}
		}

		$result['signup']['مجموع']['qom']     = array_sum(array_column($result['signup'], 'qom'));
		$result['signup']['مجموع']['mashhad'] = array_sum(array_column($result['signup'], 'mashhad'));
		$result['signup']['مجموع']['karbala'] = array_sum(array_column($result['signup'], 'karbala'));


		$result['gone']['مجموع']['qom']       = array_sum(array_column($result['gone'], 'qom'));
		$result['gone']['مجموع']['mashhad']   = array_sum(array_column($result['gone'], 'mashhad'));
		$result['gone']['مجموع']['karbala']   = array_sum(array_column($result['gone'], 'karbala'));


		$result['awaiting']['qom']            = intval($result['signup']['مجموع']['qom']) - intval($result['gone']['مجموع']['qom']);
		if(intval($result['awaiting']['qom']) < 0)
		{
			$result['awaiting']['qom'] = 0;
		}

		$result['awaiting']['mashhad']        = intval($result['signup']['مجموع']['mashhad']) - intval($result['gone']['مجموع']['mashhad']);
		if(intval($result['awaiting']['mashhad']) < 0)
		{
			$result['awaiting']['mashhad'] = 0;
		}

		$result['awaiting']['karbala']        = intval($result['signup']['مجموع']['karbala']) - intval($result['gone']['مجموع']['karbala']);
		if(intval($result['awaiting']['karbala']) < 0)
		{
			$result['awaiting']['karbala'] = 0;
		}



		return $result;
	}



	public static function stat_old()
	{

		$signup   = 0;
		$awaiting = 0;
		$signup     = 0;

		// gone group trip
		$gone_group_trip = \lib\db\karbalasetting::gone_group_trip();
		if(is_numeric($gone_group_trip))
		{
			$gone += intval($gone_group_trip);
		}

		// samte khoda qore keshi
		// 12 province in every province 40 person
		$gone += (12 * 40);
		// koye mohebbat qore keshi
		$gone += 0;
		// static number from khalili
		$gone += 0;


		$signup_group_trip = \lib\db\karbalasetting::signup_group_trip();
		if(is_numeric($signup_group_trip))
		{
			$signup += intval($signup_group_trip);
		}

		$count_signup_samtekhoda = \lib\db\karbalasetting::count_signup_samtekhoda();
		if(is_numeric($count_signup_samtekhoda))
		{
			$signup += intval($count_signup_samtekhoda);
		}

		$count_signup_koyemohebbat = \lib\db\karbalasetting::count_signup_koyemohebbat();
		if(is_numeric($count_signup_koyemohebbat))
		{
			$signup += intval($count_signup_koyemohebbat);
		}


		$count_signup_mokeb = \lib\db\karbalasetting::count_signup_mokeb();
		if(is_numeric($count_signup_mokeb))
		{
			$signup += intval($count_signup_mokeb);
		}

		$result =
		[
			'gone'     => $gone,
			'signup'   => $signup,
			'awaiting' => $signup - $gone,
		];
		// j($result);
		return $result;
	}


	private static function addr()
	{
		return __DIR__.'/karbalasetting.me.json';
	}

	public static function set($_args)
	{
		\dash\app::variable($_args);
		$setting =
		[
			'samtekhoda'   => \dash\app::request('samtekhoda') ? true : false,
			'koyemohebbat' => \dash\app::request('koyemohebbat') ? true : false,
			'arbaeen'      => \dash\app::request('arbaeen') ? true : false,
		];

		$setting = json_encode($setting, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		\dash\notif::ok(T_("Status changed"));
		\dash\file::write(self::addr(), $setting);
		return true;
	}

	public static function get()
	{
		$get = \dash\file::read(self::addr());
		if(is_string($get))
		{
			$get = json_decode($get, true);
		}

		$setting =
		[
			'samtekhoda'   => (isset($get['samtekhoda']) && $get['samtekhoda']) ? true : false,
			'koyemohebbat' => (isset($get['koyemohebbat']) && $get['koyemohebbat']) ? true : false,
			'arbaeen'      => (isset($get['arbaeen']) && $get['arbaeen']) ? true : false,
		];

		return $setting;
	}


	public static function check($_key)
	{
		$get = self::get();
		if(isset($get[$_key]) && $get[$_key])
		{
			return true;
		}
		return false;
	}
}
?>