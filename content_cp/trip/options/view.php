<?php
namespace content_cp\trip\options;


class view
{
	public static function config()
	{
		\dash\permission::access('cpTripOption');

		\dash\data::page_pictogram('cogs');

		\dash\data::page_title(T_("Request options"));

		\dash\data::page_desc(T_("change request options"));


		\dash\data::badge_link(\dash\url::here(). '/trip');

		\dash\data::badge_text(T_('Back to request list'));


		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		\dash\data::activeCity(\lib\app\travel::active_city());
		\dash\data::tripMasterActive(\lib\app\travel::trip_master_active());

		// \dash\data::tripCountPartner(\lib\app\travel::trip_count_partner());
		\dash\data::tripCountPartner_qom(\lib\app\travel::trip_count_partner('get', 'qom'));
		\dash\data::tripCountPartner_mashhad(\lib\app\travel::trip_count_partner('get', 'mashhad'));
		\dash\data::tripCountPartner_karbala(\lib\app\travel::trip_count_partner('get', 'karbala'));

		\dash\data::tripMaxAwaiting(\lib\app\travel::trip_max_awaiting());
		\dash\data::tripGetdate(\lib\app\travel::trip_getdate());


		\dash\data::groupActiveCity(\lib\app\travel::group_active_city());
		\dash\data::groupMasterActive(\lib\app\travel::group_master_active());
		\dash\data::groupCountPartnerMin(\lib\app\travel::group_count_partner_min());
		\dash\data::groupCountPartnerMax(\lib\app\travel::group_count_partner_max());
		\dash\data::groupMaxAwaiting(\lib\app\travel::group_max_awaiting());
		\dash\data::groupGetdate(\lib\app\travel::group_getdate());


	}
}
?>
