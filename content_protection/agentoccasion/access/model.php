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
				\dash\redirect::to(\dash\url::that(). '?id='. \dash\request::get('id'));
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

			if(\dash\data::editMode())
			{
				$reault = \lib\app\protectionagentoccasionchild::edit($post, \dash\request::get('cid'));
			}
			else
			{
				$reault = \lib\app\protectionagentoccasionchild::add($post);
			}


			if(\dash\engine\process::status())
			{
				if(\dash\data::editMode())
				{
					\dash\redirect::to(\dash\url::that(). '?id='. \dash\request::get('id'));

				}
				else
				{
					\dash\redirect::pwd();
				}
			}
			return;
		}

	}
}
?>
