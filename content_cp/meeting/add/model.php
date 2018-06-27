<?php
namespace content_cp\meeting\add;


class model
{
	public static function upload_gallery()
	{
		if(\dash\request::files('gallery'))
		{
			$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => 'gallery']);

			if(isset($uploaded_file['url']))
			{
				// save uploaded file
				\dash\app\posts::post_gallery(\dash\request::get('id'), $uploaded_file['url'], 'add');
			}

			if(!\dash\engine\process::status())
			{
				\dash\notif::error(T_("Can not upload file"));
			}
			else
			{
				\dash\notif::ok(T_("File successfully uploaded"));
			}

			return true;
		}
		return false;

	}

	public static function remove_gallery()
	{
		$id = \dash\request::post('id');
		if(!is_numeric($id))
		{
			return false;
		}

		\dash\app\posts::post_gallery(\dash\request::get('id'), $id, 'remove');
		\dash\redirect::pwd();

	}


	public static function check_valid_id()
	{
		$id = \dash\request::get('id');
		$id = \dash\coding::decode($id);
		if(!$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$load = \dash\db\posts::get(['id' => $id, 'limit' => 1]);

		if(!$load || !isset($load['user_id']))
		{
			\dash\notif::error(T_("Id not found"));
			return false;
		}

		if(intval($load['user_id']) !== intval(\dash\user::id()))
		{
			\dash\notif::error(T_("This meeting is not for you!"));
			return false;
		}
		return true;
	}


	public static function post()
	{
		if(self::upload_gallery())
		{
			return false;
		}

		if(\dash\request::post('type') === 'remove_gallery')
		{
			self::remove_gallery();
			return false;
		}

		if(\dash\request::get('step') === 'report')
		{
			$post =
			[
				'content' => \dash\request::post('content'),
			];

			if(!$post['content'])
			{
				\dash\notif::ok(T_("Meeting report was saved"));
				return true;
			}

			$post['content'] = addslashes($_POST['content']);

			if(!self::check_valid_id())
			{
				return false;
			}

			\dash\db\posts::update($post, \dash\coding::decode(\dash\request::get('id')));
			\dash\notif::ok(T_("Meeting report was saved"));
			\dash\redirect::pwd();
		}
		else
		{
			$post =
			[
				'subtitle'    => \dash\request::post('order'),
				'title'       => \dash\request::post('title'),
				'slug'        => \dash\user::id(). '_'. time(),
				'url'         => \dash\user::id(). '_'. time(),
				'user_id'     => \dash\user::id(),
				'publishdate' => \dash\request::post('publishdate'),
				'status'      => 'draft',
				'type'        => 'meeting',
				'language'    => 'fa',

			];

			$post['status'] = 'draft';
			$post['type']   = 'meeting';

			if(!$post['title'])
			{
				\dash\notif::error(T_("Please fill the title"), 'title');
				return false;
			}

			$tag          = \dash\request::post('tag');
			$tag          = preg_replace("/\n/", '-', $tag);
			$post['meta'] = ['member' => $tag];
			$post['meta'] = json_encode($post['meta'], JSON_UNESCAPED_UNICODE);

			$publishdate = \dash\request::post('publishdate');
			$publishdate = \dash\utility\convert::to_en_number($publishdate);

			if($publishdate && !\dash\date::db($publishdate))
			{
				\dash\notif::error(T_("Invalid parameter publishdate"), 'publishdate');
				return false;
			}

			if(\dash\language::current() === 'fa' && $publishdate && \dash\utility\jdate::is_jalali($publishdate))
			{
				$publishdate  = \dash\utility\jdate::to_gregorian($publishdate);
			}

			if(!$publishdate)
			{
				$publishdate = date("Y-m-d");
			}


			$publishtime = \dash\request::post('publishtime');
			$publishtime = \dash\utility\convert::to_en_number($publishtime);

			if($publishtime)
			{
				if(\dash\data::make_time($publishtime) === false)
				{
					\dash\notif::error(T_("Invalid meeting time"), 'publishtime');
					return false;
				}
				elseif(!$publishtime)
				{
					$publishtime = date("H:i");
				}
			}
			else
			{
				$publishtime = date("H:i");
			}


			if($publishtime)
			{
				$post['publishdate'] = $publishdate. ' '. $publishtime;
			}
			else
			{
				$post['publishdate'] = $publishdate;
			}

			if(\dash\request::get('step') === 'add' && \dash\request::get('id'))
			{
				$new_post_id = \dash\request::get('id');

				if(!self::check_valid_id())
				{
					return false;
				}
				\dash\db\posts::update($post, \dash\coding::decode(\dash\request::get('id')));
				\dash\notif::ok(T_("Meeting detail was saved"));
			}
			else
			{
				$new_post_id = \dash\db\posts::insert($post);
				if(!$new_post_id)
				{
					\dash\notif::error(T_("No way to add new meeting now"));
					return false;
				}

				$new_post_id = \dash\coding::encode($new_post_id);
			}


			if(\dash\engine\process::status())
			{
				\dash\redirect::to(\dash\url::here(). '/meeting/add?step=report&id='. $new_post_id);
				return;
			}
		}


	}
}
?>
