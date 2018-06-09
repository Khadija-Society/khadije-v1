<?php
namespace content_a\trip\profile;


class model
{

	public static function post()
	{
		$post                    = [];
		$post['gender']          = \dash\request::post('gender') ;
		$post['email']           = \dash\request::post('email');
		$post['birthday']        = \dash\request::post('birthday');
		$post['firstname']       = \dash\request::post('name');
		$post['lastname']        = \dash\request::post('lastName');
		$post['nationalcode']    = \dash\request::post('nationalcode');
		$post['father']          = \dash\request::post('father');
		$post['pasportcode']     = \dash\request::post('passport');
		$post['pasportdate']     = \dash\request::post('passportexpire');
		$post['country']         = \dash\request::post('country');
		$post['province']        = \dash\request::post('province');
		$post['city']            = \dash\request::post('city');
		$post['homeaddress']     = \dash\request::post('homeaddress');
		$post['phone']           = \dash\request::post('phone');
		$post['displayname']     = trim($post['firstname'] . ' '. $post['lastname']);
		$post['married']         = \dash\request::post('Married') ;
		$post['zipcode']         = \dash\request::post('zipcode');


		$partner = true;

		$trip = \dash\data::tripDetail();
		if(isset($trip['place']))
		{
			$count_partner = \lib\app\travel::trip_count_partner('get', $trip['place']);
			if($count_partner === '0')
			{
				$post['status'] = 'awaiting';

				$partner = false;

				if(\dash\user::detail('mobile') && \dash\utility\filter::mobile(\dash\user::detail('mobile')))
				{
					if(isset($trip['place']))
					{
						$city = T_($trip['place']);
						$msg = "درخواست شما برای تشرف به $city با موفقیت ثبت شد.";
					}
					else
					{
						$msg = "درخواست شما برای تشرف با موفقیت ثبت شد.";
					}

					\dash\utility\sms::send(\dash\user::detail('mobile'), $msg);
				}
			}
		}


		\lib\app\myuser::edit($post);

		if(\dash\engine\process::status())
		{
			if($partner)
			{
				\dash\notif::ok(T_("Your detail was saved"));
				\dash\redirect::to(\dash\url::here(). '/trip/partner?trip='. \dash\request::get('trip'));
			}
			else
			{
				\dash\notif::ok(T_("Your trip request was saved"));
				\dash\redirect::to(\dash\url::here(). '/trip');
			}
		}

	}
}
?>
