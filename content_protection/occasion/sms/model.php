<?php
namespace content_protection\occasion\sms;


class model
{
	public static function post()
	{
		\lib\app\protectionagentoccasion::agent_send_sms(\dash\request::get('id'));
		\dash\redirect::pwd();
	}
}
?>