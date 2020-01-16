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

			'clergy'      => \dash\request::post('rohani'),
			'admin'       => \dash\request::post('modir'),
			'adminoffice'    => \dash\request::post('negahban'),
			'missionary'    => \dash\request::post('moballeq'),
		];

		\lib\app\send::add($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::this());
		}

	}
}
?>