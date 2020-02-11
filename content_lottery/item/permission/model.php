<?php
namespace content_lottery\item\permission;


class model
{
	public static function post()
	{
		// \dash\permission::access('mPlaceEdit');

		$post =
		[
			'title'       => \dash\request::post('title'),
			'subtitle'    => \dash\request::post('subtitle'),
			'desc'        => \dash\request::post('desc'),
			'status'      => \dash\request::post('status'),


			'termandcondition' => \dash\request::post('termandcondition'),
			'agreemessage' => \dash\request::post('agreemessage'),
			// 'requiredfield' => \dash\request::post('requiredfield'),
			// 'permission' => \dash\request::post('permission'),
			'signupmessage' => \dash\request::post('signupmessage'),
			'lotterytitle' => \dash\request::post('lotterytitle'),
			'lotteryfooter' => \dash\request::post('lotteryfooter'),
		];


		$file = \dash\app\file::upload_quick('file');
		if($file)
		{
			$post['file'] = $file;
		}

		\lib\app\syslottery::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
			\dash\redirect::to(\dash\url::here(). '/item'. \dash\data::xTypeStart());
		}

	}
}
?>