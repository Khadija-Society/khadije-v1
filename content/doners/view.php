<?php
namespace content\doners;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Doners"));
		\dash\data::page_desc(T_("List of our last doners"));

		\dash\data::bodyclass('unselectable');
		\dash\data::wayList(\lib\app\donate::way_list());

		\dash\data::DonersList(\lib\db\mytransactions::transaction_list());

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