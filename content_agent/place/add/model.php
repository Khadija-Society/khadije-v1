<?php
namespace content_agent\place\add;


class model
{
	public static function post()
	{
		// \dash\permission::access('mPlaceAdd');

		$post =
		[
			'title'  => \dash\request::post('title'),
		];

		$result = \lib\app\agentplace::add($post);

		if(\dash\engine\process::status())
		{
			if(isset($result['id']))
			{
				\dash\redirect::to(\dash\url::this(). '/edit?id='. $result['id']);
			}
			else
			{
				\dash\redirect::to(\dash\url::this());
			}
		}

	}
}
?>