<?php
namespace content_cp\trip\add;


class model
{

	public static function post()
	{

		$post           = [];
		$post['city']   = \dash\request::post('city');

		if(!$post['city'])
		{
			\dash\notif::error(T_("Please select city"));
			return false;
		}

		$post['status'] = 'awaiting';
		$post['type']   = 'group';
		$post['mobile'] = \dash\request::post('mobile');

		$travel_id = \lib\app\travel::add($post, ['force_admin' => true]);

		if(\dash\engine\process::status() && $travel_id)
		{
			$user_id = \dash\temp::get('travel_user_id');
			$user_id = \dash\coding::encode($user_id);

			\dash\notif::ok(T_("Your Travel was saved"));
			\dash\redirect::to(\dash\url::this(). '/profile?user='. $user_id. '&id='. $travel_id);
		}
	}
}
?>
