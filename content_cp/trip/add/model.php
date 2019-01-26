<?php
namespace content_cp\trip\add;


class model
{

	public static function post()
	{

		$post           = [];
		$post['city']   = \dash\request::post('city');
		$post['status'] = 'awaiting';
		$post['type']   = 'group';
		$post['mobile'] = \dash\request::post('mobile');

		$travel_id = \lib\app\travel::add($post, ['force_admin' => true]);

		if(\dash\engine\process::status() && $travel_id)
		{
			\dash\notif::ok(T_("Your Travel was saved"));
			\dash\redirect::to(\dash\url::this());
		}
	}
}
?>
