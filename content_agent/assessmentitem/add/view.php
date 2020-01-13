<?php
namespace content_agent\assessmentitem\add;


class view
{
	public static function config()
	{
		\dash\permission::access('mAssessmentitemAdd');
		\dash\data::page_title(T_("Add new assessmentitem"));
		\dash\data::page_pictogram('plus-circle');
		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back'));
	}
}
?>