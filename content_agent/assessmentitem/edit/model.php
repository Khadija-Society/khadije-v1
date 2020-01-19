<?php
namespace content_agent\assessmentitem\edit;


class model
{
	public static function post()
	{
		// \dash\permission::access('mAssessmentitemEdit');

		$post =
		[
			'title'  => \dash\request::post('title'),
			'city'   => \dash\request::get('city'),
			'rate'   => \dash\request::post('rate'),
			'job'    => \dash\request::post('job') == '0' ? null : \dash\request::post('job'),
			'sort'   => \dash\request::post('sort'),
			'status' => \dash\request::post('status'),
		];


		\lib\app\assessmentitem::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). '/assessmentitem'. \dash\data::xCityStart());
		}

	}
}
?>