<?php
namespace content_lottery\item\message;


class model
{
	public static function post()
	{

		$post =
		[

			'termandcondition' => \dash\request::post('termandcondition'),
			'agreemessage'     => \dash\request::post('agreemessage'),
			'signupmessage'    => \dash\request::post('signupmessage'),
			'lotterytitle'     => \dash\request::post('lotterytitle'),
			'lotteryfooter'    => \dash\request::post('lotteryfooter'),
		];

		\lib\app\syslottery::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}

	}
}
?>