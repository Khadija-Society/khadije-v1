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

		if(\dash\request::get('token'))
		{
			$get_msg = \dash\utility\pay\setting::final_msg(\dash\request::get('token'));
			if($get_msg)
			{
				if(isset($get_msg['condition']) && $get_msg['condition'] === 'ok' && isset($get_msg['plus']))
				{
					\dash\data::paymentVerifyMsg(T_("Thanks for your holy payment, :amount sucsessfully recived", ['amount' => \dash\utility\human::fitNumber($get_msg['plus'])]));
					\dash\data::paymentVerifyMsgTrue(true);
				}
				else
				{
					\dash\data::paymentVerifyMsg(T_("Payment unsuccessfull"));
				}
			}
			else
			{
				\dash\redirect::to(\dash\url::this());
			}
		}
	}
}
?>