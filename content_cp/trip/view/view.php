<?php
namespace content_cp\trip\view;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("View request detail"));
		\dash\data::page_desc(T_("check request and update status"));

		\dash\data::badge_link(\dash\url::here(). '/trip');
		\dash\data::badge_text(T_('Back to request list'));

		\dash\data::bodyclass('unselectable siftal');

		$travelDetail = \lib\db\travels::search(null, ['travels.id' => \dash\request::get('id'), 'pagenation' => false]);

		\dash\data::travelDetail($travelDetail);

		if(isset($travelDetail[0]))
		{
			\dash\data::travelDetail($travelDetail[0]);
		}


		\dash\data::travelPartner(\lib\db\travelusers::get_travel_child(\dash\request::get('id')));

		// load partner detail
		if(\dash\request::get('partner') && is_numeric(\dash\request::get('partner')))
		{
			\dash\data::editMode(true);

			if(is_array(\dash\data::travelPartner()))
			{
				foreach (\dash\data::travelPartner() as $key => $value)
				{
					if(isset($value['id']) && intval($value['id']) === intval(\dash\request::get('partner')))
					{
						\dash\data::partnerDetail($value);
						break;
					}
				}
			}
		}
	}
}
?>
