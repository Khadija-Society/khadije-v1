<?php
namespace content_protection\setting;


class model
{

	public static function post()
	{
		if(\dash\request::post('remove') === 'remove')
		{

			$reault = \lib\app\protectiontype::edit(['status' => 'deleted'], \dash\request::post('id'));

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}

			return;
		}


		$post =
		[
			'title'       => \dash\request::post('title'),
		];

		if(\dash\data::editMode())
		{
			$reault = \lib\app\protectiontype::edit($post, \dash\request::get('id'));
			if(\dash\engine\process::status())
			{
				\dash\redirect::to(\dash\url::that());
			}
		}
		else
		{
			$reault = \lib\app\protectiontype::add($post);
			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
		}
	}
}
?>
