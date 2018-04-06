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

		if(\lib\engine\process::status() && $travel_id)
		{
			\lib\notif::ok(T_("Your Travel was saved"));
			\lib\redirect::to(\dash\url::here(). '/trip/profile?trip='. $travel_id);
		}
	}
}
?>
