<?php
namespace content\donate;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Donate"));
		\dash\data::page_desc(T_("Pay your donate online with below form"));


		\dash\data::bodyclass('unselectable');
		\dash\data::wayList(\lib\app\donate::way_list());
		\dash\data::donateArchive(\lib\db\mytransactions::user_transaction('cash'));

		if(\dash\session::get('payment_request_start'))
		{
			if(\dash\utility\payment\verify::get_status())
			{
				$amount = \dash\utility\payment\verify::get_amount();
				\dash\data::paymentVerify_msg_true(true);
				\dash\data::paymentVerify_msg(T_("Thanks for your holy payment, :amount sucsessfully recived", ['amount' => \dash\utility\human::fitNumber($amount)]));
				\lib\app\donate::sms_success($amount);
			}
			else
			{
				\dash\data::paymentVerify_msg_true(false);
				\dash\data::paymentVerify_msg(T_("Payment unsuccessfull"));
			}

			\dash\utility\payment\verify::clear_session();
		}
	}
}
?>