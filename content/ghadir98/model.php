<?php
namespace content\ghadir98;


class model extends \content_support\ticket\contact_ticket\model
{
	public static function post()
	{

		$name         = \dash\request::post('name');
		if(!$name)
		{
			\dash\notif::error(T_("Please fill the name"), 'name');
			return false;
		}

		$mobile       = \dash\request::post('mobile');
		if(!$mobile)
		{
			\dash\notif::error(T_("Please fill the mobile"), 'mobile');
			return false;
		}

		$email        = \dash\request::post('email');


		$jobtitle  = \dash\request::post('jobtitle');
		if(!$jobtitle)
		{
			\dash\notif::error("لطفا عنوان فعالیت را وارد کنید", 'jobtitle');
			return false;
		}


		$city         = \dash\request::post('city');
		if(!$city)
		{
			\dash\notif::error(T_("Please fill the city"), 'city');
			return false;
		}

		\dash\temp::set('tempTicketTitle', T_("Request to join"));

		$content      = \dash\request::post('content');

		$content_raw = '';
		$content_raw .= T_('name') . ' '. $name. "\n";
		$content_raw .= T_('mobile') . ' '. $mobile. "\n";
		$content_raw .= T_('email') . ' '. $email. "\n";
		$content_raw .= ' عنوان فعالیت'. $jobtitle. "\n";
		$content_raw .= T_('City') . ' '. $city. "\n";
		$content_raw .= "\n --- \n". $content;

		return parent::post($content_raw);


	}
}
?>
