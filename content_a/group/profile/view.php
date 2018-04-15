<?php
namespace content_a\group\profile;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new group request"). ' | '. T_('Step 2'));
		\dash\data::page_desc(T_('fill your personal data in this step'). ' '. T_('In next step fill your partner data'));

		\dash\data::userdetail(\dash\db\users::get(['id' => \dash\user::id(), 'limit' => 1]));
		\dash\data::userdetail(\content_a\view::fix_value(\dash\data::userdetail()));
		self::static_var();
	}


	public static function static_var()
	{
		$countryList = \dash\utility\location\countres::list('name', 'name - localname');
		\dash\data::countryList(implode(',', $countryList));

		$cityList = \dash\utility\location\cites::list('localname');
		$cityList = array_unique($cityList);
		\dash\data::cityList(implode(',', $cityList));

		$proviceList = \dash\utility\location\provinces::list('localname');
		$proviceList = array_unique($proviceList);
		\dash\data::proviceList($proviceList);
	}
}
?>
