<?php
namespace content_m\trip\partner;


class view
{
	public static function config()
	{
		\dash\permission::access('cpTripView');

		\dash\data::page_pictogram('users');

		\dash\data::page_title(T_("List of trip partner"));
		\dash\data::page_desc(' ');

		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to request list'));

		\dash\data::travelPartner(\lib\db\travelusers::get_travel_child(\dash\request::get('id')));

		if(\dash\request::get('export') === 'export_partner')
		{
			\dash\utility\export::csv(['name' => 'export_trip_'. \dash\request::get('id'), 'data' => self::myList()]);
			return;
		}
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


	private static function myList()
	{
		$list = \dash\data::travelPartner();
		$new_list = [];
		if(!is_array($list))
		{
			return [];
		}

		foreach ($list as $key => $value)
		{
			$new_list[$key]['id']                 = $value['id'];
			$new_list[$key]['displayname']        = $value['displayname'];
			$new_list[$key]['gender']             = $value['gender'];
			$new_list[$key]['mobile']             = $value['mobile'];
			$new_list[$key]['email']              = $value['email'];
			$new_list[$key]['avatar']             = $value['avatar'];
			$new_list[$key]['birthday']           = $value['birthday'];
			$new_list[$key]['birthday_jalaly']    = \dash\datetime::fit($value['birthday'], null, 'date');
			$new_list[$key]['firstname']          = $value['firstname'];
			$new_list[$key]['lastname']           = $value['lastname'];
			$new_list[$key]['father']             = $value['father'];
			$new_list[$key]['nationalcode']       = $value['nationalcode'];
			$new_list[$key]['pasportcode']        = $value['pasportcode'];
			$new_list[$key]['pasportdate']        = $value['pasportdate'];
			$new_list[$key]['education']          = $value['education'];
			$new_list[$key]['city']               = $value['city'];
			$new_list[$key]['province']           = $value['province'];
			$new_list[$key]['country']            = $value['country'];
			$new_list[$key]['phone']              = $value['phone'];
			$new_list[$key]['married']            = $value['married'];
			$new_list[$key]['zipcode']            = $value['zipcode'];
			$new_list[$key]['desc']               = $value['desc'];
			$new_list[$key]['job']                = $value['job'];
			$new_list[$key]['nationality']        = $value['nationality'];
			$new_list[$key]['marital']            = $value['marital'];
			$new_list[$key]['foreign']            = $value['foreign'];
			$new_list[$key]['mobile2']            = $value['mobile2'];
			$new_list[$key]['qom']                = $value['qom'];
			$new_list[$key]['mashhad']            = $value['mashhad'];
			$new_list[$key]['karbala']            = $value['karbala'];
		}
		return $new_list;
	}
}
?>
