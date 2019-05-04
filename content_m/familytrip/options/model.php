<?php
namespace content_m\familytrip\options;


class model
{

	public static function post()
	{
		\dash\permission::access('cpFamilyTripOption');

		if(\dash\request::post('type') === 'family')
		{
			\lib\app\travel::trip_master_active(\dash\request::post('master_active'));
			// \lib\app\travel::trip_count_partner(\dash\request::post('count_partner'));
			\lib\app\travel::trip_count_partner(\dash\request::post('count_partner_qom'), 'qom');
			\lib\app\travel::trip_count_partner(\dash\request::post('count_partner_karbala'), 'karbala');
			\lib\app\travel::trip_count_partner(\dash\request::post('count_partner_mashhad'), 'mashhad');

			\lib\app\travel::trip_max_awaiting(\dash\request::post('max_awaiting'));
			\lib\app\travel::trip_getdate(\dash\request::post('getdate'));

			\lib\app\travel::city_signup_setting('karbala', \dash\request::post('karbala'));
			\lib\app\travel::city_signup_setting('mashhad', \dash\request::post('mashhad'));
			\lib\app\travel::city_signup_setting('qom', \dash\request::post('qom'));

			\lib\app\travel::trip_set_terms('family', 'qom', \dash\request::post('termconditionqom') ? $_POST['termconditionqom'] : null);
			\lib\app\travel::trip_set_terms('family', 'mashhad', \dash\request::post('termconditionmashhad') ? $_POST['termconditionmashhad'] : null);
			\lib\app\travel::trip_set_terms('family', 'karbala', \dash\request::post('termconditionkarbala') ? $_POST['termconditionkarbala'] : null);


		}


		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Your change was saved"));
		}

	}
}
?>
