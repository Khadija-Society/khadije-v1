<?php
namespace content_protection\protectagent\edit;


class model
{
	public static function post()
	{
		$post =
		[
			'title'             => \dash\request::post('title'),
			'mobile'            => \dash\request::post('mobile'),
			'type'              => \dash\request::post('type'),
			'status'            => \dash\request::post('status'),
			'desc'              => \dash\request::post('desc'),
			'bankaccountnumber' => \dash\request::post('bankaccountnumber'),
			'bankshaba'         => \dash\request::post('bankshaba'),
			'bankhesab'         => \dash\request::post('bankhesab'),
			'bankcart'          => \dash\request::post('bankcart'),
			'bankname'          => \dash\request::post('bankname'),
			'bankownername'     => \dash\request::post('bankownername'),
			'province'          => \dash\request::post('province'),
			'city'              => \dash\request::post('city'),
			'address'           => \dash\request::post('address'),

		];


		\lib\app\protectagent::edit($post, \dash\request::get('id'));


		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}

	}
}
?>