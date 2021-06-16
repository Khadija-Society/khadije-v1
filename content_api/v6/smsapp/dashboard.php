<?php
namespace content_api\v6\smsapp;


class dashboard
{
	public static function get()
	{
		$gateway = \dash\utility\filter::mobile(\dash\header::get('gateway'));
		return \lib\app\sms::dashboard_detail($gateway, \lib\app\platoon\tools::get_index_locked());
	}
}
?>