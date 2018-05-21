<?php
namespace content_a\advice\request;


class model
{

	public static function post()
	{

		$post            = [];
		$post['need_id'] = \dash\request::post('need');
		$post['status']  = 'draft';
		$post['type']    = 'advice';

		$service_id = \lib\app\service::add($post);

		if(\dash\engine\process::status() && $service_id)
		{
			\dash\notif::ok(T_("Your advice was saved"));
			\dash\redirect::to(\dash\url::here(). '/advice/profile?id='. $service_id);
		}
	}
}
?>
