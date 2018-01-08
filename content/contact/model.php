<?php
namespace content\contact;

class model extends \mvc\model
{

	// log callers
	// user:send:contact
	// user:send:contact:fail
	// user:send:contact:empty:message
	// user:send:contact:empty:mobile
	// user:send:contact:wrong:captha
	// user:send:contact:register:by:mobile

	/**
	 * save contact form
	 */
	public function post_contact()
	{
		if(\lib\utility::post('username'))
		{
			\lib\debug::error(T_("Whate are you doing?"));
			return false;
		}

		$count = \lib\session::get('count_fill_contact');
		if($count)
		{
			\lib\session::set('count_fill_contact', $count + 1, null, 60 * 60);
		}
		else
		{
			\lib\session::set('count_fill_contact', 1, null, 60 * 60);
		}

		if($count >= 3)
		{
			\lib\debug::warn(T_("How are you?"). ":)");
			return false;
		}

		// check login
		if($this->login())
		{
			$user_id = $this->login("id");

			// get mobile from user login session
			$mobile = $this->login('mobile');

			if(!$mobile)
			{
				$mobile = \lib\utility::post('mobile');
			}

			// get display name from user login session
			$displayname = $this->login("displayname");
			// user not set users display name, we get display name from contact form
			if(!$displayname)
			{
				$displayname = \lib\utility::post("name");
			}
			// get email from user login session
			$email = \lib\db\users::get_email($user_id);
			// user not set users email, we get email from contact form
			if(!$email)
			{
				$email = \lib\utility::post("email");
			}
		}
		else
		{
			// users not registered
			$user_id     = null;
			$displayname = \lib\utility::post("name");
			$email       = \lib\utility::post("email");
			$mobile      = \lib\utility::post("mobile");
		}
		// get the content
		$content = \lib\utility::post("content");

		// save log meta
		$log_meta =
		[
			'meta' =>
			[
				'login'    => $this->login('all'),
				'language' => \lib\define::get_language(),
				'post'     => \lib\utility::post(),
			]
		];

		/**
		 * register user if set mobile and not register
		 */
		if($mobile && !$this->login())
		{
			$mobile = \lib\utility\filter::mobile($mobile);

			// check valid mobile
			if($mobile)
			{
				// check existing mobile
				$exists_user = \lib\db\users::get_by_mobile($mobile);
				// register if the mobile is valid
				if(!$exists_user || empty($exists_user))
				{
					// signup user by site_guest
					$user_id = \lib\db\users::signup(['mobile' => $mobile, 'displayname' => $displayname]);
					// save log by caller 'user:send:contact:register:by:mobile'
					\lib\db\logs::set('user:send:contact:register:by:mobile', $user_id, $log_meta);
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
			\lib\debug::error(T_("Please try type something!"), "content");
			return false;
		}
		// ready to insert comments
		$args =
		[
			'author'  => $displayname,
			'email'   => $email,
			'type'    => 'comment',
			'content' => $content,
			'user_id' => $user_id
		];
		// insert comments
		$result = \lib\db\comments::insert($args);
		if($result)
		{
			// $mail =
			// [
			// 	'from'    => 'info@khadije.com',
			// 	'to'      => 'info@khadije.com',
			// 	'subject' => 'contact',
			// 	'body'    => $content,
			// 	'debug'   => false,
			// ];
			// \lib\utility\mail::send($mail);

			\lib\db\logs::set('user:send:contact', $user_id, $log_meta);
			\lib\debug::true(T_("Thank You For contacting us"));
		}
		else
		{
			\lib\db\logs::set('user:send:contact:fail', $user_id, $log_meta);
			\lib\debug::error(T_("We could'nt save the contact"));
		}
	}
}