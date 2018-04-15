<?php
namespace content_a\donate;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Donate"));
		\dash\data::page_desc(\dash\data::site_title(). ' | '. \dash\data::site_desc());

		\dash\data::wayList(\lib\app\donate::way_list());
		\dash\data::donateArchive(\lib\db\mytransactions::user_transaction('cash'));

		if(\dash\session::get('payment_request_start'))
		{
			if(\lib\utility\payment::get_status())
			{
				\lib\utility\payment::clear_session();
				\dash\data::paymentVerify_msg(T_("Thanks for your payment"));
				\lib\utility\donate::sms_success();
			}
			else
			{
				\dash\data::paymentVerify_msg(T_("Payment unsuccessfull"));
			}
		}
	}
}
?>
