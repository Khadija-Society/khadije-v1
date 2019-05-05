<?php
namespace content_api\v6\smsapp;


class dashboard
{
	public static function get()
	{
		return \lib\app\sms::dashboard_detail();
	}
}
?>