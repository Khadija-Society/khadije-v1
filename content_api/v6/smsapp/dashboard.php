<?php
namespace content_api\v6\smsapp;


class dashboard
{
	public static function get()
	{

		$result           = [];
		$result['status'] = \content_api\v6\smsapp\controller::status();

		$day              = [];
		$day['send']      = rand(1,1000);
		$day['receive']   = rand(1,1000);

		$week             = [];
		$week['send']     = rand(1,1000);
		$week['receive']  = rand(1,1000);

		$month            = [];
		$month['send']    = rand(1,1000);
		$month['receive'] = rand(1,1000);

		$total            = [];
		$total['send']    = rand(1,1000);
		$total['receive'] = rand(1,1000);


		$result['day']    = $day;
		$result['week']   = $week;
		$result['month']  = $month;
		$result['total']  = $total;
		return $result;
	}
}
?>