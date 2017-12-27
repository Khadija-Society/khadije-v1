<?php
namespace content_cp\options\cityplace;


class model extends \addons\content_cp\main\model
{

	public function post_cityplace()
	{
		$post          = [];
		$post['place'] = \lib\utility::post('place');
		$post['city']  = \lib\utility::post('city');

		\lib\app\travel::set_cityplace($post);

		if(\lib\debug::$status)
		{
			\lib\debug::true(T_("Way successfully added"));
			$this->redirector($this->url('full'));
		}
	}
}
?>
