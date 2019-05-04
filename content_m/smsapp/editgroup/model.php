<?php
namespace content_m\smsapp\editgroup;


class model
{
	public static function post()
	{
		$post            = [];
		$post['title']   = \dash\request::post('title');
		$post['type']    = \dash\request::post('type');
		$post['analyze'] = \dash\request::post('analyze');
		$post['ismoney'] = \dash\request::post('ismoney');
		$post['status']  = \dash\request::post('status');

		$result = \lib\app\smsgroup::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
