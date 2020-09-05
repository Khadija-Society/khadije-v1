<?php
namespace content_protection\agentoccasion\bank;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Bank account detail"));


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));



	}

}
?>
