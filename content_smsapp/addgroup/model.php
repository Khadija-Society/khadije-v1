<?php
namespace content_smsapp\addgroup;


class model
{
	public static function post()
	{
		$post            = [];
		$post['title']   = \dash\request::post('title');
		$post['type']    = 'other';
		$post['analyze'] = null;
		$post['ismoney'] = null;
		$post['status']  = 'enable';

		$result = \lib\app\smsgroup::add($post);

		if(\dash\engine\process::status() && isset($result['id']))
		{
			\dash\redirect::to(\dash\url::here(). '/editgroup?id='. $result['id']);
		}
	}
}
?>
