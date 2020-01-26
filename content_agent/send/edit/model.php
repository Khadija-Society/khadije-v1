<?php
namespace content_agent\send\edit;


class model
{
	public static function post()
	{



		$post =
		[

			'title'          => \dash\request::post('title'),

			'starttime'      => \dash\request::post('starttime'),
			'endtime'        => \dash\request::post('endtime'),

			'startdate'      => \dash\request::post('startdate'),
			'enddate'        => \dash\request::post('enddate'),

			'clergy'         => \dash\request::post('clergy'),
			'admin'          => \dash\request::post('admin'),

			'servant'        => \dash\request::post('servant'),
			'maddah'         => \dash\request::post('maddah_id'),
			'rabet'         => \dash\request::post('rabet_id'),
			'nazer'          => \dash\request::post('nazer_id'),
			'khadem'         => \dash\request::post('khadem_id'),
			'khadem2'        => \dash\request::post('khadem2_id'),
			'status'         => \dash\request::post('status'),
			'desc'         => \dash\request::post('desc'),
		];


		\lib\app\send::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::pwd());
		}

	}
}
?>