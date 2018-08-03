<?php
namespace content_cp\festival\referee;


class model
{
	public static function upload_avatar()
	{
		if(\dash\request::files('avatar'))
		{
			$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => 'avatar']);

			if(isset($uploaded_file['url']))
			{
				\dash\notif::direct();

				return $uploaded_file['url'];
			}
			// if in upload have error return
			if(!\dash\engine\process::status())
			{
				return false;
			}
		}
		return null;
	}

	public static function post()
	{
		if(\dash\request::get('type') === 'add' || \dash\request::get('referee'))
		{
			\dash\permission::access('fpRefereeAdd');

			$post            = [];

			$file = self::upload_avatar();

			if($file === false)
			{
				return false;
			}

			if($file)
			{
				$post['logo'] = $file;
			}

			$post['title']       = \dash\request::post('title');
			$post['website']     = \dash\request::post('website') ? $_POST['website'] : null;
			$post['desc']        = \dash\request::post('desc');
			$post['type']        = 'referee';

			$post['subtitle']    = \dash\request::post('subtitle');
			$post['telegram']    = \dash\request::post('telegram');
			$post['facebook']    = \dash\request::post('facebook');
			$post['twitter']     = \dash\request::post('twitter');
			$post['instagram']   = \dash\request::post('instagram');
			$post['linkedin']    = \dash\request::post('linkedin');

			if(\dash\request::get('referee'))
			{
				$post['status']      = \dash\request::post('status');
			}

			$post['festival_id'] = \dash\request::get('id');

			if(\dash\request::get('referee'))
			{
				$result = \lib\app\festivaldetail::edit($post, \dash\request::get('referee'));
				if(\dash\engine\process::status())
				{
					\dash\redirect::to(\dash\url::this(). '/referee?id='. \dash\request::get('id'));
				}
			}
			else
			{
				$result = \lib\app\festivaldetail::add($post);

				if(\dash\engine\process::status())
				{
					if(isset($result['id']))
					{
						\dash\redirect::to(\dash\url::this(). '/referee?id='. \dash\request::get('id'));
					}
					else
					{
						\dash\redirect::to(\dash\url::this());
					}
				}
			}
		}
	}
}
?>
