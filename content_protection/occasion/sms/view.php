<?php
namespace content_protection\occasion\sms;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit occasion"));
		\dash\data::page_desc(T_('Edit name or description of this occasion or change status of it.'));
		\dash\data::page_pictogram('edit');

		\dash\data::badge_link(\dash\url::this());

		\dash\data::badge_text(T_('Back to list of occasion'));

		$myDate = \lib\app\protectionagentoccasion::get_sms_date(\dash\request::get('id'));
		\dash\data::myDate($myDate);

		if(\dash\request::get('exportmobileallow'))
		{
			$result = \lib\app\protectionagentoccasion::agent_send_sms_get_mobile(\dash\request::get('id'));
			\dash\utility\export::csv(['name' => 'Export_occasion_'. \dash\request::get('id'), 'data' => $result]);
		}


	}
}
?>