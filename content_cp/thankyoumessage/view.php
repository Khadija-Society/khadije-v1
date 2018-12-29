<?php
namespace content_cp\thankyoumessage;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Thank you message"));
		\dash\data::page_desc(T_(' '));
		\dash\data::page_pictogram('commenting-o');

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

		$message = \lib\app\message::get();
		\dash\data::dataRow($message);

	}
}
?>