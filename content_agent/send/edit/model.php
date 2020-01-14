<?php
namespace content_agent\send\edit;


class model
{
	public static function post()
	{

		$post =
		[

			'startdate' => \dash\request::post('startdate'),
			'enddate'   => \dash\request::post('enddate'),

		];

		\lib\app\send::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::pwd());
		}

	}
}
?>