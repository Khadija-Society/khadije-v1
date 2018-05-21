<?php
namespace content_delneveshte\home;


class model
{
	public static function post()
	{
		$desc   = trim(\dash\request::post('desc'));
		$title  = trim(\dash\request::post('title'));
		$mobile = trim(\dash\request::post('mobile'));

		if(!$desc)
		{
			\dash\notif::warn(T_("Dele tangat che mikhahad bego..."), 'desc');
			return false;
		}

		if(\dash\request::post('username'))
		{
			\dash\notif::error(T_("Whate are you doing?"));
			return false;
		}

		$count = \dash\session::get('count_fill_contact');
		if($count)
		{
			\dash\session::set('count_fill_contact', $count + 1, null, 60 * 60);
		}
		else
		{
			\dash\session::set('count_fill_contact', 1, null, 60 * 60);
		}

		if(!\dash\url::isLocal())
		{

			if($count >= 5)
			{
				\dash\notif::warn(T_("How are you?"). ":)");
				return false;
			}

		}

		// check login
		if(\dash\user::login())
		{
			$user_id = \dash\user::id();

			// get mobile from user login session
			$mobile = \dash\user::login('mobile');

			if(!$mobile)
			{
				$mobile = \dash\request::post('mobile');
			}

			// get display name from user login session
			$displayname = \dash\user::login("displayname");
			// user not set users display name, we get display name from contact form
			if(!$displayname)
			{
				$displayname = \dash\request::post("title");
			}

		}
		else
		{
			// users not registered
			$user_id     = null;
			$displayname = \dash\request::post("title");
			$mobile      = \dash\request::post("mobile");
		}

		/**
		 * register user if set mobile and not register
		 */
		if($mobile && !\dash\user::login())
		{
			$mobile = \dash\utility\filter::mobile($mobile);

			// check valid mobile
			if($mobile)
			{
				// check existing mobile
				$exists_user = \dash\db\users::get_by_mobile($mobile);
				// register if the mobile is valid
				if(!$exists_user || empty($exists_user))
				{
					// signup user by site_guest
					$user_id = \dash\db\users::signup(['mobile' => $mobile, 'displayname' => $title]);
					// save log by caller 'user:send:contact:register:by:mobile'
					\dash\db\logs::set('user:send:delneveshte:register:by:mobile', $user_id);
				}
				elseif(isset($exists_user['id']))
				{
					$user_id = $exists_user['id'];
				}
			}
		}

		// ready to insert comments
		$args =
		[
			'author'  => $title,
			'type'    => 'delneveshte',
			'content' => $desc,
			'user_id' => $user_id
		];
		// insert comments
		$result = \dash\db\comments::insert($args);
		if($result)
		{
			\dash\notif::ok(T_("Your gele vas saved and after accept you can see it in this page"));
			\dash\redirect::pwd();
		}
		else
		{
			\dash\notif::error(T_("We could'nt save the contact"));
		}

	}
}
?>
