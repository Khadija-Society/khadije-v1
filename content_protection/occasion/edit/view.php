<?php
namespace content_protection\occasion\edit;


class view
{
	public static function config()
	{
		\dash\data::page_title(T_("Edit occasion"));
		\dash\data::page_desc(T_('Edit name or description of this occasion or change status of it.'));
		\dash\data::page_pictogram('edit');

				$url_get            = [];
		$url_get['city']    = \dash\request::get('city');
		$url_get['job']     = \dash\request::get('job');
		$url_get['job_for'] = \dash\request::get('job_for');

		\dash\data::badge_link(\dash\url::this(). '?'. http_build_query($url_get));

		\dash\data::badge_text(T_('Back to list of Assessmentitems'));

		$id     = \dash\request::get('id');
		$result = \lib\app\occasion::get($id);

		if(!$result)
		{
			\dash\header::status(403, T_("Invalid occasion id"));
		}

		\dash\data::dataRow($result);


	}
}
?>