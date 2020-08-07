<?php
namespace content_protection\occasion\add;


class model
{
	public static function post()
	{


		$post =
		[
			'title' => \dash\request::post('title'),

		];

		$result = \lib\app\occasion::add($post);

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
				\dash\redirect::to(\dash\url::this(). \dash\data::xCityStart());
			}
		}

	}
}
?>