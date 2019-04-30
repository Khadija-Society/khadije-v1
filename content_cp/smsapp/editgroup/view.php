<?php
namespace content_cp\smsapp\editgroup;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');
		\dash\data::page_title(T_("Edit sms group"));
		\dash\data::page_desc(T_("You cat set some group for sms"));
		\dash\data::badge_link(\dash\url::this(). '/listgroup');
		\dash\data::badge_text(T_('Sms group list'));

	}
}
?>
