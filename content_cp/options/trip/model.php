<?php
namespace content_cp\options\trip;


class model extends \addons\content_cp\main\model
{

	public function post_trip()
	{
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
