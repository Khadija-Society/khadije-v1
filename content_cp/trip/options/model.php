<?php
namespace content_cp\trip\options;


class model
{

	public static function post()
	{
		\dash\permission::access('cpTripOption');



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

			\lib\app\travel::trip_set_terms('group', null, \dash\request::post('termcondition') ? $_POST['termcondition'] : null);

		}

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Your change was saved"));
		}

	}
}
?>
