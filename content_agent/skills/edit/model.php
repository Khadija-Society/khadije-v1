<?php
namespace content_agent\skills\edit;


class model
{
	public static function post()
	{
		$post =
		[
			'title'           => \dash\request::post('title'),
			'status'          => \dash\request::post('status'),
		];


		$file = \dash\app\file::upload_quick('file1');

		if($file)
		{
			$post['file'] = $file;
		}


		\lib\app\skills::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::this(). \dash\data::xCityStart());
			// \dash\redirect::pwd();
		}

	}
}
?>