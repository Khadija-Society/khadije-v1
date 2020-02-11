<?php
namespace content_agent\assessmentitem\edit;


class model
{
	public static function post()
	{


		$post =
		[
			'title'   => \dash\request::post('title'),
			'city'    => \dash\request::get('city'),
			'rate'    => \dash\request::post('rate'),
			'job'     => \dash\request::post('job') == '0' ? null : \dash\request::post('job'),
			'job_for' => \dash\request::post('job_for') == '0' ? null : \dash\request::post('job_for'),
			'sort'    => \dash\request::post('sort'),
			'status'  => \dash\request::post('status'),
		];


		\lib\app\assessmentitem::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			$url_get            = [];
			$url_get['city']    = \dash\request::get('city');
			$url_get['job']     = \dash\request::get('job');
			$url_get['job_for'] = \dash\request::get('job_for');

			\dash\redirect::to(\dash\url::here(). '/assessmentitem?'. http_build_query($url_get));
		}

	}
}
?>