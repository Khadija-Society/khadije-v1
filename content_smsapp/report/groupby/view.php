<?php
namespace content_smsapp\report\groupby;

class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Count sms send per day"));

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

		$gateway   = \dash\request::get('gateway');
		$dataTable = \lib\app\sms\report::get_groupby($gateway);

		\dash\data::dataTable($dataTable);

		$mobile = \lib\db\sms::group_by_togateway();
		if(is_array($mobile) && count($mobile) > 1)
		{
			\dash\data::togateway($mobile);
		}


	}
}
?>