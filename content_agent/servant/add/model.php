<?php
namespace content_agent\servant\add;


class model
{
	public static function post()
	{
		$post =
		[
			'member'      => \dash\request::post('member'),
			'job'         => \dash\request::post('job'),
			'city'        => \dash\request::get('city'),
			'mobile'      => \dash\request::post('memberTl'),
			'gender'      => \dash\request::post('memberGender'),
			'displayname' => \dash\request::post('memberN'),
		];

		$result = \lib\app\servant::add($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::this(). \dash\data::xCityStart());
		}

	}
}
?>