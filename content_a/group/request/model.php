<?php
namespace content_a\group\request;


class model extends \content_a\main\model
{

	public function post_group()
	{

		$post           = [];
		$post['city']   = \lib\utility::post('city');
		$post['status'] = 'draft';
		$post['type']   = 'group';

		$travel_id = \lib\app\travel::add($post);

		if(\lib\debug::$status && $travel_id)
		{
			\lib\debug::true(T_("Your Travel was saved"));
			$this->redirector(\lib\url::here(). '/group/profile?trip='. $travel_id);
		}
	}
}
?>
