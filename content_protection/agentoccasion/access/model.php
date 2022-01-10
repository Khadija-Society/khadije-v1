<?php
namespace content_protection\agentoccasion\access;


class model
{

	public static function post()
	{
		if(\dash\request::post('remove') === 'remove')
		{
			\lib\app\protectionagentoccasionchild::remove(\dash\data::occasionID(), \dash\request::get('id'), \dash\request::post('id'));

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
		}
		else
		{
			$post =
			[
				'occasion_id'               => \dash\data::occasionID(),
				'protectionagetnoccasionid' => \dash\request::get('id'),
				'mobile'                    => \dash\request::post('cm'),
				'displayname'               => \dash\request::post('displayname'),
				'capacity'                  => \dash\request::post('capacity'),
			];


			$reault = \lib\app\protectionagentoccasionchild::add($post);

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
			return;
		}

	}
}
?>
