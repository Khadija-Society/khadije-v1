<?php
namespace content_protection\agentoccasion\access;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Access another to fill list"));


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));


		$list = \lib\app\protectionagentoccasionchild::get(\dash\data::occasionID(), \dash\request::get('id'));

		\dash\data::childList($list);

	}

}
?>
