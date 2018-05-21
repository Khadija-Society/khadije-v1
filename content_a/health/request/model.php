<?php
namespace content_a\health\request;


class model
{

	public static function post()
	{

		$post            = [];
		$post['need_id'] = \dash\request::post('need');
		$post['status']  = 'draft';
		$post['type']    = 'health';

		$service_id = \lib\app\service::add($post);

		if(\dash\engine\process::status() && $service_id)
		{
			\dash\notif::ok(T_("Your health was saved"));
			\dash\redirect::to(\dash\url::here(). '/health/profile?id='. $service_id);
		}
	}
}
?>
