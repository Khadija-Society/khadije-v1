<?php
namespace content_protection\protectagent\add;


class model
{
	public static function post()
	{


		$post =
		[
			'title'  => \dash\request::post('title'),
			'mobile' => \dash\request::post('mobile'),
			'type'   => \dash\request::post('type'),
		];

		$result = \lib\app\protectagent::add($post);

		if(\dash\engine\process::status())
		{
			if(isset($result['id']))
			{
				$url_get            = [];
				$url_get['id']      = $result['id'];
				\dash\redirect::to(\dash\url::this(). '/edit?'. http_build_query($url_get));
			}
			else
			{
				\dash\redirect::to(\dash\url::this());
			}
		}

	}
}
?>