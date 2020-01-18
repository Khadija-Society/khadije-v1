<?php
namespace content_agent\send\edit;


class model
{
	public static function post()
	{


		$post =
		[


			'place_id'    => \dash\request::post('place'),

			'startdate'   => \dash\request::post('startdate'),
			'enddate'     => \dash\request::post('enddate'),



			'mobile'      => \dash\request::post('memberTl'),
			'gender'      => \dash\request::post('memberGender'),
			'displayname' => \dash\request::post('memberN'),

			'clergy'      => \dash\request::post('rohani'),
			'admin'       => \dash\request::post('modir'),
			'adminoffice'    => \dash\request::post('negahban'),
			'missionary'    => \dash\request::post('moballeq'),
			'servant'    => \dash\request::post('servant'),
		];

		\lib\app\send::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::pwd());
		}

	}
}
?>