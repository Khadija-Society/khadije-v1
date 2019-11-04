<?php
namespace content_mokeb\place\edit;


class model
{
	public static function post()
	{
		\dash\permission::access('mPlaceEdit');

		$post =
		[
			'title'       => \dash\request::post('title'),
			'subtitle'    => \dash\request::post('subtitle'),
			'city'        => \dash\request::post('city'),
			'activetime'  => \dash\request::post('activetime'),
			'capacity' => \dash\request::post('capacity'),
			'file'        => \dash\request::post('file'),
			'sort'        => \dash\request::post('sort'),
			'desc'        => \dash\request::post('desc'),
			'address'     => \dash\request::post('address'),
			'status'      => \dash\request::post('status'),
			'cleantime'   => \dash\request::post('cleantime'),
			'gender'      => \dash\request::post('gender'),
			'from'        => \dash\request::post('from'),
			'to'          => \dash\request::post('to'),

		];

		$perm    = [];
		$allpost = \dash\request::post();
		foreach ($allpost as $key => $value)
		{
			if(substr($key, 0, 5) === 'perm_')
			{
				$perm[] = substr($key, 5);
			}
		}

		$post['perm'] = $perm;

		$file = \dash\app\file::upload_quick('file');
		if($file)
		{
			$post['file'] = $file;
		}

		\lib\app\place::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). '/place');
		}

	}
}
?>