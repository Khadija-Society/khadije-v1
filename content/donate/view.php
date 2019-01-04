<?php
namespace content\donate;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Donate"));
		\dash\data::page_desc(T_("Pay your donate online with below form"));


		\dash\data::bodyclass('unselectable');
		\dash\data::wayList(\lib\app\need::active_list('donate'));

		\dash\data::donateArchive(\lib\db\mytransactions::user_transaction('cash'));
		if(\dash\request::get('nazr'))
		{
			$list = \dash\data::wayList();
			if(is_array($list))
			{
				foreach ($list as $key => $value)
				{
					if(isset($value['linkurl']) && $value['linkurl'] === \dash\request::get('nazr'))
					{
						\dash\data::waySelected($value);
					}
				}
			}
		}

		// if(\dash\session::get('paymentVerifyMsgTrue'))
		// {
		// 	\dash\data::paymentVerifyMsgTrue(\dash\session::get('paymentVerifyMsgTrue'));
		// }
		// else
		// {
		// 	\dash\data::paymentVerifyMsg(\dash\session::get('paymentVerifyMsg'));
		// }

		// \dash\session::set('paymentVerifyMsg', null);
		// \dash\session::set('paymentVerifyMsgTrue', null);



	}


	public static function after_pay($_detail)
	{
		$amount = isset($_detail['plus']) ? $_detail['plus'] : 0;
		\lib\app\donate::sms_success($amount);
		// \dash\session::set('paymentVerifyMsgTrue', true);
		// \dash\session::set('paymentVerifyMsg', T_("Thanks for your holy payment, :amount sucsessfully recived", ['amount' => \dash\utility\human::fitNumber($amount)]));
		// if(isset($_detail['condition']) && $_detail['condition'] === 'ok')
		// {
		// }
		// else
		// {
		// 	\dash\session::set('paymentVerifyMsgTrue', false);
		// 	\dash\session::set('paymentVerifyMsg', T_("Payment unsuccessfull"));
		// }
	}
}
?>