<?php
namespace content_a\trip\request;


class model extends \content_a\main\model
{

	public function post_trip()
	{

		$post           = [];
		$post['city']   = \lib\request::post('city');
		$post['status'] = 'draft';
		$post['type']   = 'family';

		$travel_id = \lib\app\travel::add($post);

		if(\lib\debug::$status && $travel_id)
		{
			\lib\debug::true(T_("Your Travel was saved"));
			\lib\redirect::to(\lib\url::here(). '/trip/profile?trip='. $travel_id);
		}
	}
}
?>
