<?php
namespace content_m\product\add;


class model
{
	public static function post()
	{
		\dash\permission::access('mProductAdd');

		$post =
		[
			'title'  => \dash\request::post('title'),
		];

		$result = \lib\app\product::add($post);

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