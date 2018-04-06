<?php
namespace content_a\service\request;


class model extends \content_a\main\model
{

	public function post_service()
	{

		$post            = [];
		$post['need_id'] = \lib\request::post('need');
		$post['status']  = 'draft';

		$service_id = \lib\app\service::add($post);

		if(\lib\engine\process::status() && $service_id)
		{
			\lib\notif::ok(T_("Your request was saved"));
			\lib\redirect::to(\dash\url::here(). '/service/profile?id='. $service_id);
		}
	}
}
?>
