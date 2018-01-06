<?php
namespace content_a\service\request;


class model extends \content_a\main\model
{

	public function post_service()
	{

		$post           = [];
		$post['city']   = \lib\utility::post('city');
		$post['status'] = 'draft';
		$post['type']   = 'family';

		$travel_id = \lib\app\travel::add($post);

		if(\lib\debug::$status && $travel_id)
		{
			\lib\debug::true(T_("Your Travel was saved"));
			$this->redirector($this->url('baseFull'). '/service/profile?service='. $travel_id);
		}
	}
}
?>
