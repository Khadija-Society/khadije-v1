<?php
namespace content_agent\servant\edit;


class model
{
	public static function post()
	{
		if(\dash\request::post('type') === 'remove')
		{
			\lib\app\servant::remove(\dash\request::get('sid'));

			if(\dash\engine\process::status())
			{
				\dash\redirect::to(\dash\url::this(). \dash\data::xCityStart());
			}
		}

		$post =
		[
			'job'    => \dash\request::post('job'),
			'city'   => \dash\request::get('city'),
			'status' => \dash\request::post('status'),
		];

		$file = \dash\app\file::upload_quick('file1');

		if($file)
		{
			$post['file'] = $file;
		}


		\lib\app\servant::edit($post, \dash\request::get('sid'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}

	}
}
?>