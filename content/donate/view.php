<?php
namespace content\donate;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Donate"));
		\dash\data::page_desc(T_("Join to the charity and participate in the pilgrimage reward"). '. '. \dash\data::site_slogan());

		// add special cover
		\dash\data::page_cover(\dash\url::static(). '/images/karbala/karbala-1.jpg');

		\dash\data::bodyclass('unselectable');
		$wayList = \lib\app\need::active_list('donate');
		\dash\data::wayList($wayList);

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

		$aqiqeWay = [];
		if(is_array($wayList))
		{
			foreach ($wayList as $key => $value)
			{
				if(isset($value['title']) && strpos($value['title'], 'عقیقه') !== false)
				{
					$aqiqeWay[] = $value['title'];
				}
			}
		}
		\dash\data::aqiqeWay(implode('|', $aqiqeWay));

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