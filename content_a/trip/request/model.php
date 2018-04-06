<?php
namespace content_a\trip\request;


class model extends \content_a\main\model
{

	public function post_trip()
	{

		$post           = [];
		$post['city']   = \dash\request::post('city');
		$post['status'] = 'draft';
		$post['type']   = 'family';

		$travel_id = \lib\app\travel::add($post);

		if(\lib\engine\process::status() && $travel_id)
		{
			\dash\notif::ok(T_("Your Travel was saved"));
			\dash\redirect::to(\dash\url::here(). '/trip/profile?trip='. $travel_id);
		}
	}
}
?>
