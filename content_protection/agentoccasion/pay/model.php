<?php
namespace content_protection\agentoccasion\pay;


class model
{

	public static function post()
	{
		$post =
		[
			'occation_id'               => \dash\data::occasionID(),
			'protectionagetnoccasionid' => \dash\request::get('id'),
			'paydate'                   => \dash\request::post('paydate'),
			'total_price'               => \dash\request::post('total_price'),
			'trackingnumber'            => \dash\request::post('trackingnumber'),
			'desc'                      => \dash\request::post('desc'),
			'is_admin'                  => true,
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
