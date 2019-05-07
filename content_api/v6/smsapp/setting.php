<?php
namespace content_api\v6\smsapp;


class setting
{
	public static function get()
	{
		return \lib\app\sms::setting_file();
	}
}
?>