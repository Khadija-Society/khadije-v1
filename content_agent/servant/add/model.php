<?php
namespace content_agent\servant\add;


class model
{
	public static function post()
	{
		$post =
		[
			'member' => \dash\request::post('member'),
			'job'    => \dash\request::post('job'),
			'city'   => \dash\request::post('city'),
		];

		$result = \lib\app\servant::add($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::this());
		}

	}
}
?>