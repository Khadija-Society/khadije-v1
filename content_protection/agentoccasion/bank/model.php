<?php
namespace content_protection\agentoccasion\bank;


class model
{

	public static function post()
	{
		$post =
		[
			'occation_id'               => \dash\data::occasionID(),
			'protectionagetnoccasionid' => \dash\request::get('id'),

			'bankshaba'                 => \dash\request::post('bankshaba'),
			'bankhesab'                 => \dash\request::post('bankhesab'),
			'bankcart'                  => \dash\request::post('bankcart'),
			'bankname'                  => \dash\request::post('bankname'),
			'bankownername'             => \dash\request::post('bankownername'),
		];



		$reault = \lib\app\protectionagentoccasion::edit($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
		return;

	}
}
?>
