<?php
namespace content\comment;

class model
{
	/**
	 * save contact form
	 */
	public static function post()
	{
		if(\dash\request::post('username'))
		{
			\dash\notif::error(T_("Whate are you doing?"));
			return false;
		}

		$count = \dash\session::get('count_fill_comment');
		if($count)
		{
			\dash\session::set('count_fill_comment', $count + 1, null, 60 * 60);
		}
		else
		{
			\dash\session::set('count_fill_comment', 1, null, 60 * 60);
		}

		if(!\dash\url::isLocal())
		{
			if($count >= 4)
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
				$displayname = \dash\request::post("name");
			}
			// get email from user login session
			$email = \dash\db\users::get_email($user_id);
			// user not set users email, we get email from contact form
			if(!$email)
			{
				$email = \dash\request::post("email");
			}
		}
		else
		{
			// users not registered
			$user_id     = null;
			$displayname = \dash\request::post("name");
			$email       = \dash\request::post("email");
			$mobile      = \dash\request::post("mobile");
		}
		// get the content
		$content = \dash\request::post("content");

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
					$user_id = \dash\db\users::signup(['mobile' => $mobile, 'displayname' => $displayname]);
					// save log by caller 'user:send:contact:register:by:mobile'
					\dash\db\logs::set('user:send:contact:register:by:mobile', $user_id, null);
				}
				elseif(isset($exists_user['id']))
				{
					$user_id = $exists_user['id'];
				}
			}
		}

		// check content
		if($content == '')
		{
			\dash\notif::error(T_("Please try type something!"), "content");
			return false;
		}

		$content  = $_POST['content'];

		if(!\dash\request::post('post_id'))
		{
			\dash\notif::error(T_("Invalid post id"));
			return false;
		}

		// ready to insert comments
		$args =
		[
			'author'  => $displayname,
			'email'   => $email,
			'post_id' => \dash\request::post('post_id'),
			'type'    => 'comment',
			'content' => $content,
			'mobile'  => \dash\request::post("mobile"),
			'user_id' => $user_id
		];

		// insert comments
		$result = \dash\app\comment::add($args);
		if($result)
		{
			\dash\notif::ok(T_("Your comment saved"));
		}
		else
		{
			// \dash\redirect::pwd();
			// \dash\notif::error(T_("We could'nt save the comment"));
		}
	}
}