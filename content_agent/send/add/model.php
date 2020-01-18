<?php
namespace content_agent\send\add;


class model
{
	public static function post()
	{

		$post =
		[
			'city'        => \dash\request::post('city'),

			'place_id'    => \dash\request::post('place'),

			'startdate'   => \dash\request::post('startdate'),
			'enddate'     => \dash\request::post('enddate'),

			'user_id'     => \dash\request::get('user'),

			'mobile'      => \dash\request::post('memberTl'),
			'gender'      => \dash\request::post('memberGender'),
			'displayname' => \dash\request::post('memberN'),

			'clergy'      => \dash\request::post('clergy'),
			'admin'       => \dash\request::post('admin'),
			'adminoffice'    => \dash\request::post('adminoffice'),
			'missionary'    => \dash\request::post('missionary'),
			'servant'    => \dash\request::post('servant'),
		];

		\lib\app\send::add($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::this());
		}

	}
}
?>