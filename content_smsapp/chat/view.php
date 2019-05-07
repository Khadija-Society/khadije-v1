<?php
namespace content_smsapp\chat;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');

		\dash\data::page_title(T_("Chat list"));

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Dashboard'));

		$filterArray = [];
		$args        = [];

		$dataTable = \lib\app\sms::chat_list($args);

		\dash\data::dataTable($dataTable);



	}
}
?>
