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

	public static function getPost()
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

		$post =
		[
			'id'          => \dash\request::get('id'),
			'subtitle'    => \dash\request::post('subtitle'),
			'excerpt'     => \dash\request::post('excerpt'),
			'title'       => \dash\request::post('title'),
			'tag'         => \dash\request::post('tag'),
			'slug'        => \dash\request::post('slug'),
			'content'     => isset($_POST['content']) ? $_POST['content'] : null,
			'publishdate' => \dash\request::post('publishdate'),
			'publishtime' => \dash\request::post('publishtime'),
			'status'      => \dash\request::post('status'),
			'comment'     => \dash\request::post('comment'),
			'language'    => \dash\request::post('language'),
			'parent'      => \dash\request::post('parent'),
		];


		if(!$post['status'])
		{
			$post['status'] = 'draft';
		}

		if(!\dash\permission::check('cpPostsEditStatus'))
		{
			unset($post['status']);
		}

		if(\dash\request::get('type'))
		{
			$post['type'] = \dash\request::get('type');
		}

		$all_post = \dash\request::post();

		$post['cat'] = [];

		foreach ($all_post as $key => $value)
		{
			if(substr($key, 0, 4) === 'cat_')
			{
				$post['cat'][] = substr($key, 4);
			}
		}

		if(\dash\request::files('thumb'))
		{
			$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => 'thumb']);

			if(isset($uploaded_file['url']))
			{
				$post['thumb'] = $uploaded_file['url'];
			}
			// if in upload have error return
			if(!\dash\engine\process::status())
			{
				return false;
			}
		}

		// var_dump($post);exit();
		return $post;

	}

	public static function post()
	{
		$posts = self::getPost();

		if(!$posts || !\dash\engine\process::status())
		{
			return false;
		}

		$post_detail = \dash\app\posts::add($posts);

		if(\dash\engine\process::status() && isset($post_detail['post_id']))
		{
			\dash\redirect::to(\dash\url::here(). '/posts/edit?id='. $post_detail['post_id']);
			return;
		}
	}
}
?>
