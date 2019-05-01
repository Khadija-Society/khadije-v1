<?php
namespace content_cp\smsapp\viewsms;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');
		\dash\data::page_title(T_("View sms detail"));
		\dash\data::page_desc(T_("You cat set some group for sms"));
		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to dashboard'));

	}
}
?>
