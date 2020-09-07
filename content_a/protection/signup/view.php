<?php
namespace content_a\protection\signup;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Protection user detail"));
		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to dashboard'));


	}
}
?>
