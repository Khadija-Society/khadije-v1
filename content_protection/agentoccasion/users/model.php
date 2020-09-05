<?php
namespace content_protection\agentoccasion\users;


class model
{

	public static function post()
	{
		$occasion_id = \dash\request::get('id');
		$useragentid = \dash\request::post('useragentid');

		if(\dash\request::post('type') === 'reject')
		{
			\lib\app\protectagentuser::update_status($occasion_id, $useragentid, 'reject');

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}

			return;
		}

		if(\dash\request::post('type') === 'accept')
		{
			\lib\app\protectagentuser::update_status($occasion_id, $useragentid, 'accept');

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
			return;
		}


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
			'occation_id'     => \dash\data::occasionID(),
			'mobile'          => \dash\request::post('mobile'),
			'displayname'     => \dash\request::post('displayname'),
			'nationalcode'    => \dash\request::post('nationalcode'),
			'city'            => \dash\request::post('city'),
			'type_id'         => \dash\request::post('type_id'),
			'gender'          => \dash\request::post('gender'),
			'married'         => \dash\request::post('married'),
			'protectioncount' => \dash\request::post('protectioncount'),

		];

		if(\dash\data::editMode())
		{
			$reault = \lib\app\protectagentuser::admin_edit($post, \dash\request::get('person'));
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
