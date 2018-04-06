<?php
namespace content_a\group\request;


class model extends \content_a\main\model
{

	public function post_group()
	{

		$post           = [];
		$post['city']   = \lib\request::post('city');
		$post['status'] = 'draft';
		$post['type']   = 'group';

		$travel_id = \lib\app\travel::add($post);

		if(\lib\engine\process::status() && $travel_id)
		{
			\lib\notif::ok(T_("Your Travel was saved"));
			\lib\redirect::to(\dash\url::here(). '/group/profile?trip='. $travel_id);
		}
	}
}
?>
