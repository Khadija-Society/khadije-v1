<?php
namespace content_agent\assessmentitem\add;


class view
{
	public static function config()
	{
		// \dash\permission::access('mAssessmentitemAdd');
		\dash\data::page_title(T_("Add new assessmentitem"));
		\dash\data::page_pictogram('plus-circle');

		$url_get            = [];
		$url_get['city']    = \dash\request::get('city');
		$url_get['job']     = \dash\request::get('job');
		$url_get['job_for'] = \dash\request::get('job_for');

		\dash\data::badge_link(\dash\url::this(). '?'. http_build_query($url_get));

		\dash\data::badge_text(T_('Back'));
	}
}
?>