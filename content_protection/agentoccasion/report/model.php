<?php
namespace content_protection\agentoccasion\report;


class model
{

	public static function post()
	{
		$post =
		[
			'occation_id'               => \dash\data::occasionID(),
			'protectionagetnoccasionid' => \dash\request::get('id'),
			'report'                    => \dash\request::post('report'),
			'is_admin'                  => true,
		];

		$reault = \lib\app\protectionagentoccasion::edit($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}


	}
}
?>
