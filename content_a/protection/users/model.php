<?php
namespace content_a\protection\users;


class model
{

	public static function post()
	{

		if(\dash\request::post('remove') === 'remove')
		{
			$post =
			[
				'occation_id'  => \dash\data::occasionID(),
				'protectagentuser_id'  => \dash\request::post('id'),
			];

			$reault = \lib\app\protectagentuser::remove($post);

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}

			return;
		}


		$post =
		[
			'occation_id'  => \dash\data::occasionID(),
			'mobile'       => \dash\request::post('mobile'),
			'displayname'  => \dash\request::post('displayname'),
			'nationalcode' => \dash\request::post('nationalcode'),
		];

		if(\dash\data::editMode())
		{
			$reault = \lib\app\protectagentuser::edit($post, \dash\request::get('person'));
			if(\dash\engine\process::status())
			{
				\dash\redirect::to(\dash\url::that(). '?id='. \dash\request::get('id'));
			}
		}
		else
		{
			$reault = \lib\app\protectagentuser::add($post);
			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
		}
	}
}
?>
