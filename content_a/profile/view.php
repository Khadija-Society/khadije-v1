<?php
namespace content_a\profile;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Khadije Dashboard"));
		\dash\data::page_desc(\dash\data::site_desc());

		\dash\data::userdetail(\dash\db\users::get(['id' => \dash\user::id(), 'limit' => 1]));
		\dash\data::userdetail(\content_a\view::fix_value(\dash\data::userdetail()));

		self::static_var();

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

		$countryList = \dash\utility\location\countres::list('name', 'name - localname');
		\dash\data::countryList(implode(',', $countryList));

		$cityList = \dash\utility\location\cites::list('localname');
		$cityList = array_unique($cityList);
		\dash\data::cityList(implode(',', $cityList));

		$proviceList = \dash\utility\location\provinces::list('localname');
		$proviceList = array_unique($proviceList);
		\dash\data::proviceList(implode(',', $proviceList));
	}
}
?>
