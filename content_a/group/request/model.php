<?php
namespace content_a\group\request;


class model extends \content_a\main\model
{

	public function post_group()
	{

		$post           = [];
		$post['city']   = \dash\request::post('city');
		$post['status'] = 'draft';
		$post['type']   = 'group';

		$travel_id = \lib\app\travel::add($post);

		if(\dash\engine\process::status() && $travel_id)
		{
			\dash\notif::ok(T_("Your Travel was saved"));
			\dash\redirect::to(\dash\url::here(). '/group/profile?trip='. $travel_id);
		}
	}
}
?>
