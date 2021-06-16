<?php
namespace content_smsapp\force;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('question');

		\dash\data::page_title(T_("Sms list"));
		\dash\data::page_desc(T_("Sms list"));
		\dash\data::badge_link(\dash\url::here(). '/settings'. \dash\data::platoonGet());
		\dash\data::badge_text(T_('Settings'));


	}


}
?>
