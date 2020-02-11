<?php
namespace content_lottery\item\edit;


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
		];


		$file = \dash\app\file::upload_quick('file');
		if($file)
		{
			$post['file'] = $file;
		}

		\lib\app\syslottery::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::to(\dash\url::here(). '/item'. \dash\data::xTypeStart());
		}

	}
}
?>