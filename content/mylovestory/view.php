<?php
namespace content\mylovestory;


class view
{
	public static function config()
	{
		$download_link = \content\mylovestory\model::pay_before();
		// if($download_link && \dash\request::get('download'))
		// {
		// 	$book_path = __DIR__.'/mylovestory.pdf';
		// 	\dash\file::download($book_path);
		// }

		// if(\dash\request::get('download'))
		// {
		// 	\dash\redirect::to(\dash\url::this());
		// }



		\dash\data::page_title(T_("This is you and my love story"));
		\dash\data::page_desc(T_("Buy and download PDF version of :title book", ['title' => \dash\data::page_title()]));

		// if($payment_is_ok)
		// {
		// 	\dash\data:: paymentVerifyMsgTrue(true);
		// 	\dash\data:: paymentVerifyMsg(T_("Thanks for your buy book"));
		// 	\dash\db\users::update(['bookmylovestory' => 1], \dash\user::id());
		// 	\dash\user::refresh();
		// 	$download_link = true;
		// }

		\dash\data::downloaLink($download_link);


	}
}
?>