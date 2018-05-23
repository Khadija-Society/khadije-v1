<?php
namespace content_delneveshte\home;


class model
{
	public static function post()
	{

		if(\dash\request::post('like'))
		{
			if(!isset($_SESSION['delneveshte_like']))
			{
				$_SESSION['delneveshte_like'] = [];
			}

			$like = \dash\request::post('like');
			$like_id = \dash\coding::decode($like);

			if(!$like_id)
			{
				return;
			}

			if(!in_array($like, $_SESSION['delneveshte_like']))
			{
				$_SESSION['delneveshte_like'][] = $like;
				\dash\db\comments::set_comment_data($like_id, 'plus');
			}
			else
			{
				unset($_SESSION['delneveshte_like'][array_search($like, $_SESSION['delneveshte_like'])]);
				\dash\db\comments::set_comment_data($like_id, 'minus');
			}

			return;
		}

		$desc       = \dash\request::post('desc');
		$title      = \dash\request::post('title');
		$mobile_raw = \dash\request::post('mobile');
		$mobile     = \dash\utility\filter::mobile($mobile_raw);
		$gender     = \dash\request::post('switchGender') ? 'female' : 'male';

		if(!$desc)
		{
			\dash\notif::warn(T_("Dele tangat che mikhahad bego..."), 'desc');
			return false;
		}

		$desc = $_POST['desc'];

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

		$args =
		[
			'author'  => $title,
			'type'    => 'delneveshte',
			'content' => $desc,
			'user_id' => $user_id,
			'meta'    => $meta,
			'mobile'  => \dash\request::post('mobile'),
		];

		// insert comments
		$result = \dash\app\comment::add($args);
		if($result)
		{
			\dash\notif::ok(T_("Your gele vas saved and after accept you can see it in this page"));

			if(!isset($_SESSION['delneveshte']))
			{
				$_SESSION['delneveshte'] = [];
			}

			$_SESSION['delneveshte'][] = array_merge($args, ['id' => 251, 'status' => 'awaiting', 'datecreated' => date("Y-m-d H:i:s")]);
			\dash\redirect::pwd();
		}
		else
		{
			// \dash\notif::error(T_("We could not save the contact"));
		}
	}
}
?>
