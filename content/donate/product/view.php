<?php
namespace content\donate\product;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Donate product"));
		\dash\data::page_desc(T_("Join to the charity and participate in the pilgrimage reward"). '. '. \dash\data::site_slogan());

		// // add special cover
		\dash\data::page_cover(\dash\url::static(). '/images/karbala/karbala-2.jpg');

		\dash\data::bodyclass('unselectable');
		$productList = \lib\app\product::active_list('donate');
		\dash\data::productList($productList);

		\dash\data::donateArchive(\lib\db\mytransactions::user_transaction('cash'));


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