<?php
namespace content_a\trip\request;


class model extends \content_a\main\model
{

	public function post_trip()
	{

		$post         = [];
		$post['city'] = \lib\utility::post('city');

		$travel_id = \lib\app\travel::add($post);

		if(\lib\debug::$status && $travel_id)
		{
			\lib\debug::true(T_("Your Travel was saved"));
			$this->redirector($this->url('baseFull'). '/trip/profile?trip='. $travel_id);
		}
	}
}
?>
