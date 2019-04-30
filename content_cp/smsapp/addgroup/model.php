<?php
namespace content_cp\smsapp\addgroup;


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

		$result = \lib\app\smsgroup::add($post);

		if(\dash\engine\process::status() && isset($result['id']))
		{
			\dash\redirect::to(\dash\url::this(). '/editgroup?id='. $result['id']);
		}
	}
}
?>
