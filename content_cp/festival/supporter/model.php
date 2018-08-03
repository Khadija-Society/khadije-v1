<?php
namespace content_cp\festival\supporter;


class model
{
	public static function upload_logo()
	{
		if(\dash\request::files('logo'))
		{
			$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => 'logo']);

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
		if(\dash\request::get('type') === 'add' || \dash\request::get('supporter'))
		{
			\dash\permission::access('fpSupporterAdd');

			$post            = [];

			$file = self::upload_logo();

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
			$post['type']        = 'supporter';

			if(\dash\request::get('supporter'))
			{
				$post['status']      = \dash\request::post('status');
			}

			$post['festival_id'] = \dash\request::get('id');

			if(\dash\request::get('supporter'))
			{
				$result = \lib\app\festivaldetail::edit($post, \dash\request::get('supporter'));
				if(\dash\engine\process::status())
				{
					\dash\redirect::to(\dash\url::this(). '/supporter?id='. \dash\request::get('id'));
				}
			}
			else
			{
				$result = \lib\app\festivaldetail::add($post);

				if(\dash\engine\process::status())
				{
					if(isset($result['id']))
					{
						\dash\redirect::to(\dash\url::this(). '/supporter?id='. \dash\request::get('id'));
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
