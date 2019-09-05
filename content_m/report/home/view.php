<?php
namespace content_m\report\home;


class view
{
	public static function config()
	{
		\dash\permission::access('cpReportView');

		\dash\data::page_pictogram('chart');

		\dash\data::page_title(T_('Report list'));
		\dash\data::page_desc(T_('Some financial reports for management.'));

		\dash\data::badge_text(T_('Back to dashboard'));
		\dash\data::badge_link(\dash\url::here());

		if(\dash\permission::check('cpDonateTotalPay'))
		{
			$payment_args              = [];
			$payment_args['donate']    = 'cash';
			$payment_args['condition'] = 'ok';

			\dash\data::totalPaid(\dash\app\transaction::total_paid($payment_args));
			\dash\data::totalPaidDate(\dash\app\transaction::total_paid_date(date("Y-m-d"), $payment_args));
			\dash\data::totalPaidCount(\dash\app\transaction::total_paid_count($payment_args));
		}
	}
}
?>
