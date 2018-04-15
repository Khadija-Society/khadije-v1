<?php
namespace content_a\service\request;


class model
{

	public static function post()
	{

		$post            = [];
		$post['need_id'] = \dash\request::post('need');
		$post['status']  = 'draft';

		$service_id = \lib\app\service::add($post);

		if(\dash\engine\process::status() && $service_id)
		{
			\dash\notif::ok(T_("Your request was saved"));
			\dash\redirect::to(\dash\url::here(). '/service/profile?id='. $service_id);
		}
	}
}
?>
