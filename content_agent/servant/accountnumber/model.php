<?php
namespace content_agent\servant\accountnumber;


class model
{
	public static function post()
	{

		$post =
		[
			'bank'          => \dash\request::post('bank'),
			'accountnumber' => \dash\request::post('accountnumber'),
			'cardnumber'    => \dash\request::post('cardnumber'),
			'shaba'         => \dash\request::post('shaba'),
		];

		\lib\app\myuser::edit_accountnumber($post, \dash\request::get('user'));

		\dash\redirect::pwd();



	}
}
?>