<?php
namespace content_api\v6\smsapp;


class dashboard
{
	public static function get()
	{

		$result               = [];
		$result['status']     = true;

		$total                = [];
		$total['total']       = rand(1,1000);
		$total['send']        = rand(1,1000);
		$total['receive']     = rand(1,1000);

		$thismonth            = [];
		$thismonth['total']   = rand(1,1000);
		$thismonth['send']    = rand(1,1000);
		$thismonth['receive'] = rand(1,1000);

		$today                = [];
		$today['total']       = rand(1,1000);
		$today['send']        = rand(1,1000);
		$today['receive']     = rand(1,1000);

		$result['total']      = $total;
		$result['thismonth']  = $thismonth;
		$result['today']      = $today;
		return $result;
	}
}
?>