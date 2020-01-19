<?php
namespace content_agent\servant\skills;


class model
{
	public static function post()
	{
		if(\dash\request::post('type') === 'remove')
		{
			\lib\app\skills::remove_user_skills(\dash\request::post('id'));
		}
		else
		{
			\lib\app\skills::add_user_skills(\dash\request::get('user'), \dash\request::post('skills'), \dash\request::post('rate'), \dash\request::post('desc'));
		}


		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::pwd());
		}

	}
}
?>