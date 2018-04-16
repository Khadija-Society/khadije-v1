<?php
namespace content_cp\trip\options;


class model
{

	public static function post()
	{

		if(\dash\request::post('type') === 'family')
		{
			\lib\app\travel::trip_master_active(\dash\request::post('master_active'));
			\lib\app\travel::trip_count_partner(\dash\request::post('count_partner'));
			\lib\app\travel::trip_max_awaiting(\dash\request::post('max_awaiting'));
			\lib\app\travel::trip_getdate(\dash\request::post('getdate'));

			\lib\app\travel::city_signup_setting('karbala', \dash\request::post('karbala'));
			\lib\app\travel::city_signup_setting('mashhad', \dash\request::post('mashhad'));
			\lib\app\travel::city_signup_setting('qom', \dash\request::post('qom'));
		}

		if(\dash\request::post('type') === 'group')
		{
			\lib\app\travel::group_master_active(\dash\request::post('master_active_group'));
			\lib\app\travel::group_count_partner_min(\dash\request::post('count_partner_min'));
			\lib\app\travel::group_count_partner_max(\dash\request::post('count_partner_max'));
			\lib\app\travel::group_max_awaiting(\dash\request::post('max_awaiting_group'));
			\lib\app\travel::group_getdate(\dash\request::post('getdate_group'));

			\lib\app\travel::group_city_signup_setting('karbala', \dash\request::post('karbala'));
			\lib\app\travel::group_city_signup_setting('mashhad', \dash\request::post('mashhad'));
			\lib\app\travel::group_city_signup_setting('qom', \dash\request::post('qom'));
		}

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Your change was saved"));
		}

	}
}
?>
