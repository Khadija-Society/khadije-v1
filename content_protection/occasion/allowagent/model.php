<?php
namespace content_protection\occasion\allowagent;


class model
{
	public static function post()
	{
		$post =
		[
			'agent_id'    => \dash\request::post('id'),
			'occasion_id' => \dash\request::get('id'),
			'allow'       => \dash\request::post('allow'),
		];


		\lib\app\protectionagentoccasion::set_allow($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>