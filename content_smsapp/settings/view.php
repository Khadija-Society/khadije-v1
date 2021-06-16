<?php
namespace content_smsapp\settings;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');

		\dash\data::page_title(T_("Sms group list"));
		\dash\data::page_desc(T_("You cat set some filter to group"));

		\dash\data::badge_link(\dash\url::here(). '/addgroup'. \dash\data::platoonGet());
		\dash\data::badge_text(T_('Add new group'));

		$dataTable = \lib\app\smsgroup::show_list();

		\dash\data::dataTable($dataTable);



	}
}
?>
