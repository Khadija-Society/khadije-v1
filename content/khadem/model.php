<?php
namespace content_a\service\request;


class model extends \content_a\main\model
{

	public function post_service()
	{

		$post            = [];
		$post['need_id'] = \lib\utility::post('need');
		$post['status']  = 'draft';

		$service_id = \lib\app\service::add($post);

		if(\lib\debug::$status && $service_id)
		{
			\lib\debug::true(T_("Your request was saved"));
			$this->redirector($this->url('baseFull'). '/service/profile?id='. $service_id);
		}
	}
}
?>
