<?php
namespace content_a\protection\occasion;


class model
{

	public static function post()
	{

		$post =
		[
			'occation_id'  => \dash\request::post('occation_id'),
			'mobile'       => \dash\request::post('mobile'),
			'displayname'  => \dash\request::post('displayname'),
			'nationalcode' => \dash\request::post('nationalcode'),
		];


		$reault = \lib\app\protectagentuser::add($post);
		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
