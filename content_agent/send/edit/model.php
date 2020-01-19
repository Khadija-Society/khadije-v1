<?php
namespace content_agent\send\edit;


class model
{
	public static function post()
	{



		$post =
		[

			'title'       => \dash\request::post('title'),

			'starttime'   => \dash\request::post('starttime'),
			'endtime'     => \dash\request::post('endtime'),

			'startdate'   => \dash\request::post('startdate'),
			'enddate'     => \dash\request::post('enddate'),


			'clergy'      => \dash\request::post('clergy'),
			'admin'       => \dash\request::post('admin'),
			'adminoffice' => \dash\request::post('adminoffice'),
			'missionary'  => \dash\request::post('missionary'),
			'servant'     => \dash\request::post('servant'),
		];

		\lib\app\send::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::pwd());
		}

	}
}
?>