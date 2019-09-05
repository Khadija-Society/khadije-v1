<?php
namespace content_m\product\edit;


class model
{
	public static function post()
	{
		\dash\permission::access('mProductEdit');

		$post =
		[
			'title'    => \dash\request::post('title'),
			'subtitle' => \dash\request::post('subtitle'),
			'status'   => \dash\request::post('status'),
			'unit'   => \dash\request::post('unit'),
			'sort'     => \dash\request::post('sort'),
			'desc'     => \dash\request::post('desc'),
			'price'    => \dash\request::post('price'),
		];

		$file = \dash\app\file::upload_quick('file');
		if($file)
		{
			$post['file'] = $file;
		}

		\lib\app\product::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). '/product');
		}

	}
}
?>