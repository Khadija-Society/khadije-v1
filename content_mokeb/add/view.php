<?php
namespace content_mokeb\add;


class view
{
	public static function config()
	{
		$myTitle = "موکب  ". \dash\data::mokebDetail_title();
		$myTitle .= " / ظرفیت". \dash\data::mokebDetail_capacity();
		$myTitle .= " / پر". \dash\data::mokebDetail_capacity();
		$myTitle .= " / خالی". \dash\data::mokebDetail_capacity();
		$myTitle .= " / تخلیه". \dash\data::mokebDetail_capacity();

		\dash\data::page_title($myTitle);

		self::static_var();

		self::check_nationalcode();

		\dash\data::karbalasettingSaved(\lib\app\karbalasetting::get());


	}


	private static function check_nationalcode()
	{
		$nationalcode = \dash\request::get('cnationalcode');
		if(!$nationalcode)
		{
			return;
		}

		$status = null;
		if(!\dash\utility\filter::nationalcode($nationalcode))
		{
			\dash\notif::error('کد ملی اشتباه است');
			$status = 'invalid';
			\dash\data::checkNationalcode($status);
			return;
		}

		$check = \lib\db\mokebusers::get(['nationalcode' => $nationalcode, 'limit' => 1]);
		if(isset($check['id']))
		{
			$status = 'signuped';
		}
		else
		{
			$status = 'not-signuped';
		}
		\dash\data::checkNationalcode($status);


	}

	public static function static_var()
	{
		$parentList =
		[
			"father"              => T_("Father"),
			"mother"              => T_("Mother"),
			"sister"              => T_("Sister"),
			"brother"             => T_("Brother"),
			"grandfather"         => T_("Grandfather"),
			"grandmother"         => T_("Grandmother"),
			"aunt"                => T_("Aunt"),
			"husband of the aunt" => T_("Husband of the aunt"),
			"uncle"               => T_("Uncle"),
			"boy"                 => T_("Boy"),
			"girl"                => T_("Girl"),
			"spouse"              => T_("Spouse"),
			"stepmother"          => T_("Stepmother"),
			"stepfather"          => T_("Stepfather"),
			"neighbor"            => T_("Neighbor"),
			"teacher"             => T_("Teacher"),
			"friend"              => T_("Friend"),
			"boss"                => T_("Boss"),
			"supervisor"          => T_("Supervisor"),
			"child"               => T_("Child"),
			"grandson"            => T_("Grandson"),
		];
		\dash\data::parentList(implode(',' ,array_values($parentList)));

		$countryList = \dash\utility\location\countres::$data;
		\dash\data::countryList($countryList);

		// $cityList    = \dash\utility\location\cites::key_list('localname');
		// \dash\data::cityList($cityList);

		$proviceList = \dash\utility\location\provinces::key_list('localname');
		\dash\data::proviceList($proviceList);

		$countryList = \dash\utility\location\countres::$data;
		\dash\data::countryList($countryList);

		$cityList    = \dash\utility\location\cites::$data;
		$proviceList = \dash\utility\location\provinces::key_list('localname');

		$new = [];
		foreach ($cityList as $key => $value)
		{
			$temp = '';

			if(isset($value['province']) && isset($proviceList[$value['province']]))
			{
				$temp .= $proviceList[$value['province']]. ' - ';
			}
			if(isset($value['localname']))
			{
				$temp .= $value['localname'];
			}
			$new[$key] = $temp;
		}
		asort($new);

		\dash\data::cityList($new);

	}
}
?>
