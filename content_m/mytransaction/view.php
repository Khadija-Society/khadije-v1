<?php
namespace content_m\mytransaction;

class view
{
	public static function config()
	{
		\dash\permission::access('cpDonateTotalPay');
		\dash\data::page_pictogram('card');

		\dash\data::totalPaid(\dash\app\transaction::total_paid());
		// \dash\data::totalPaidDate(\dash\app\transaction::total_paid_date(date("Y-m-d")));
		// \dash\data::totalPaidCount(\dash\app\transaction::total_paid_count());

		\dash\data::page_title(T_("Khadije Transaction Dashboard"));
		\dash\data::page_desc(T_("Khadije Transaction Dashboard"));

	}
}
?>