<?php
namespace content\doners;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Doners"));
		\dash\data::page_desc(T_("List of our last doners"));

		\dash\data::bodyclass('unselectable');

		\dash\data::DonersList(\lib\db\mytransactions::transaction_list());

		if(\dash\session::get('payment_request_start'))
		{
			if(\dash\utility\payment\verify::get_status())
			{
				$amount = \dash\utility\payment\verify::get_amount();
				\dash\data:: paymentVerifyMsgTrue(true);
				\dash\data:: paymentVerifyMsg(T_("Thanks for your holy payment, :amount sucsessfully recived", ['amount' => \dash\utility\human::fitNumber($amount)]));
				\lib\app\donate::sms_success($amount);
			}
			else
			{
				\dash\data:: paymentVerifyMsgTrue(false);
				\dash\data:: paymentVerifyMsg(T_("Payment unsuccessfull"));
			}

			\dash\utility\payment\verify::clear_session();
		}
	}
}
?>