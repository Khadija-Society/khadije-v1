<?php
namespace content_agent\assessmentitem\add;


class model
{
	public static function post()
	{
		// \dash\permission::access('mAssessmentitemAdd');

		$post =
		[
			'title' => \dash\request::post('title'),
			'job'   => \dash\request::post('job'),
			'city'  => \dash\request::get('city'),
		];

		$result = \lib\app\assessmentitem::add($post);

		if(\dash\engine\process::status())
		{
			if(isset($result['id']))
			{
				\dash\redirect::to(\dash\url::this(). '/edit?id='. $result['id']. \dash\data::xCityAnd());
			}
			else
			{
				\dash\redirect::to(\dash\url::this(). \dash\data::xCityStart());
			}
		}

	}
}
?>