<?php
namespace content_agent\place\edit;


class model
{
	public static function post()
	{
		// \dash\permission::access('mPlaceEdit');

		$post =
		[
			'title'       => \dash\request::post('title'),
			'subtitle'    => \dash\request::post('subtitle'),
			'city'        => \dash\request::get('city'),

			'capacity'    => \dash\request::post('capacity'),

			'sort'        => \dash\request::post('sort'),
			'desc'        => \dash\request::post('desc'),
			'address'     => \dash\request::post('address'),
			'status'      => \dash\request::post('status'),

			'gender'      => \dash\request::post('gender'),
			'address'      => \dash\request::post('address'),

			'adminoffice' => \dash\request::post('adminoffice') === '0' ? null : \dash\request::post('adminoffice'),
			'servant'     => \dash\request::post('servant') === '0' ? null : \dash\request::post('servant'),
			'servant2'    => \dash\request::post('servant2') === '0' ? null : \dash\request::post('servant2'),

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

		\lib\app\agentplace::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). '/place'. \dash\data::xCityStart());
		}

	}
}
?>