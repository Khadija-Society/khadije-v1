<?php
namespace content_cp\trip\options;


class model extends \addons\content_cp\main\model
{

	public function post_options()
	{

		if(\lib\request::post('type') === 'family')
		{
			\lib\app\travel::trip_master_active(\lib\request::post('master_active'));
			\lib\app\travel::trip_count_partner(\lib\request::post('count_partner'));
			\lib\app\travel::trip_max_awaiting(\lib\request::post('max_awaiting'));
			\lib\app\travel::trip_getdate(\lib\request::post('getdate'));

			\lib\app\travel::city_signup_setting('karbala', \lib\request::post('karbala'));
			\lib\app\travel::city_signup_setting('mashhad', \lib\request::post('mashhad'));
			\lib\app\travel::city_signup_setting('qom', \lib\request::post('qom'));
		}

		if(\lib\request::post('type') === 'group')
		{
			\lib\app\travel::group_master_active(\lib\request::post('master_active_group'));
			\lib\app\travel::group_count_partner_min(\lib\request::post('count_partner_min'));
			\lib\app\travel::group_count_partner_max(\lib\request::post('count_partner_max'));
			\lib\app\travel::group_max_awaiting(\lib\request::post('max_awaiting_group'));
			\lib\app\travel::group_getdate(\lib\request::post('getdate_group'));

			\lib\app\travel::group_city_signup_setting('karbala', \lib\request::post('karbala'));
			\lib\app\travel::group_city_signup_setting('mashhad', \lib\request::post('mashhad'));
			\lib\app\travel::group_city_signup_setting('qom', \lib\request::post('qom'));
		}

		if(\lib\notif::$status)
		{
			\lib\notif::true(T_("Your change was saved"));
		}

	}
}
?>
