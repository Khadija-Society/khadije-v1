<?php
namespace content_a\service\verify;


class model
{

	public static function post()
	{

		$post            = [];
		$post['need_id'] = \dash\request::get('id');
		$post['status']  = 'draft';
		$post['type']    = 'khadem';

		$service_id = \lib\app\service::add($post);

		if(\dash\engine\process::status() && $service_id)
		{
			\dash\notif::ok(T_("Your service was saved"));
			\dash\redirect::to(\dash\url::here(). '/service/profile?id='. $service_id);
		}
	}
}
?>
