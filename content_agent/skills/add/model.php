<?php
namespace content_agent\skills\add;


class model
{
	public static function post()
	{
		$post =
		[
			'title'      => \dash\request::post('title'),
		];

		$result = \lib\app\skills::add($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::this());
		}

	}
}
?>