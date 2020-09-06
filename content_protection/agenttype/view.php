<?php
namespace content_protection\agenttype;


class view
{
	public static function config()
	{

		\dash\data::page_title(T_("Agent type"));


		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back'));

		$dataTable = \lib\app\protectiontype::get_all_full('agenttype');
		\dash\data::dataTable($dataTable);
	}

}
?>
