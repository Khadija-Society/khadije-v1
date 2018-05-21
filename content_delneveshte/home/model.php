<?php
namespace content_delneveshte\home;


class model
{
	public static function post()
	{
		$desc       = trim(\dash\request::post('desc'));
		$title      = trim(\dash\request::post('title'));
		$mobile_raw = trim(\dash\request::post('mobile'));
		$mobile     = \dash\utility\filter::mobile($mobile_raw);
		$gender     = \dash\request::post('switchGender') ? 'female' : 'male';

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
		$user_id     = null;
		if(\dash\user::login())
		{
			$user_id = \dash\user::id();
		}


		if($mobile && !\dash\user::login())
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

		$meta           = [];
		$meta['gender'] = $gender;
		$meta['mobile'] = $mobile;
		$meta['name']   = $title;
		$meta = json_encode($meta, JSON_UNESCAPED_UNICODE);

		$args =
		[
			'author'  => $title,
			'type'    => 'delneveshte',
			'content' => $desc,
			'user_id' => $user_id,
			'meta'    => $meta,

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
