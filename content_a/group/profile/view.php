<?php
namespace content_a\group\profile;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Register for new group request"). ' | '. T_('Step 2'));
		\dash\data::page_desc(T_('fill your personal data in this step'). ' '. T_('In next step fill your partner data'));

		\dash\data::userdetail(\dash\db\users::get(['id' => \dash\user::id(), 'limit' => 1]));
		\dash\data::userdetail(self::fix_value(\dash\data::userdetail()));
		$this->static_var();
	}


	public static function static_var()
	{
		$country_list = \dash\utility\location\countres::list('name', 'name - localname');
		$this->data->country_list = implode(',', $country_list);

		$city_list = \dash\utility\location\cites::list('localname');
		$city_list = array_unique($city_list);
		$this->data->city_list = implode(',', $city_list);

		$provice_list = \dash\utility\location\provinces::list('localname');
		$provice_list = array_unique($provice_list);
		$this->data->provice_list = $provice_list;
	}
}
?>
