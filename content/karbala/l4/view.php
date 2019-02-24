<?php
namespace content\karbala\l4;


class view
{
	public static function config()
	{
		\dash\data::page_title("نتایج قرعه‌کشی کربلای سمت خدا- اسفند ۱۳۹۷");
		\dash\data::page_desc(\dash\data::site_desc());

		$countSingupKarbala = \lib\db\karbalausers::get_last_id();
		\dash\data::countSingupKarbala($countSingupKarbala);


		self::static_var();

		$province =
		[
			'IR-02',
			'IR-07',
			'IR-20',
			'IR-08',
			'IR-24',
			'IR-30',
			'IR-12',
			'IR-26',
			'IR-28',
			'IR-13',
			'IR-14',
			'IR-22',
		];

		$proviceList = [];
		foreach ($province as $key => $value)
		{
			$map_code = \dash\utility\location\provinces::get($value, null, 'localname');
			$proviceList[] = ['code' => $value, 'name' => $map_code];
		}

		\dash\data::proviceListL($proviceList);

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
