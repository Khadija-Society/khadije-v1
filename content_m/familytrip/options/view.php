<?php
namespace content_m\familytrip\options;


class view
{
	public static function config()
	{
		\dash\permission::access('cpFamilyTripOption');

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

		\dash\data::tripTermsqom(\lib\app\travel::trip_get_terms('family', 'qom'));
		\dash\data::tripTermsmashhad(\lib\app\travel::trip_get_terms('family', 'mashhad'));
		\dash\data::tripTermskarbala(\lib\app\travel::trip_get_terms('family', 'karbala'));



	}
}
?>
