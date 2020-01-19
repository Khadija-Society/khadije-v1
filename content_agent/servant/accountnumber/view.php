<?php
namespace content_agent\servant\accountnumber;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title("تنظیم اطلاعات بانکی");

		\dash\data::page_pictogram('user');
		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back to list of servants'));


	}
}
?>