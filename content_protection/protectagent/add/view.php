<?php
namespace content_protection\protectagent\add;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Add new protect agent"));
		\dash\data::page_pictogram('plus-circle');


		$agentType = \lib\app\protectiontype::get_all('agenttype');
		\dash\data::agentType($agentType);


		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));
	}
}
?>