<?php
namespace content_cp\options\trip;


class model extends \addons\content_cp\main\model
{

	public function post_trip()
	{

		\lib\app\travel::trip_master_active(\lib\utility::post('master_active'));
		\lib\app\travel::trip_count_partner(\lib\utility::post('count_partner'));
		\lib\app\travel::trip_max_awaiting(\lib\utility::post('max_awaiting'));
		\lib\app\travel::trip_getdate(\lib\utility::post('getdate'));

		\lib\app\travel::city_signup_setting('karbala', \lib\utility::post('karbala'));
		\lib\app\travel::city_signup_setting('mashhad', \lib\utility::post('mashhad'));
		\lib\app\travel::city_signup_setting('qom', \lib\utility::post('qom'));

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Your change was saved"));
		}

	}
}
?>
