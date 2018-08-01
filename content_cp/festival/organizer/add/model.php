<?php
namespace content_cp\organizer\add;


class model
{
	/**
	 * UploAads an logo.
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
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
		\dash\permission::access('fpDetailAdd');


		$post                = [];
		$post['title']       = \dash\request::post('title');
		$post['festival_id'] = \dash\request::get('id');
		$post['website']     = \dash\request::post('website');
		$post['desc']        = \dash\request::post('desc');
		$post['type']        = 'organizer';
		$post['status']      = \dash\request::post('status');
		$post['logo']        = self::upload_logo();

		if($post['logo'] === false)
		{
			return false;
		}

		if($post['logo'] === null)
		{
			unset($post['logo']);
		}

		if(\dash\request::get('organizer'))
		{
			$result = \lib\app\festivaldetail::edit($post, \dash\request::get('organizer'));
			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
		}
		else
		{
			$result = \lib\app\festivaldetail::add($post);

			if(\dash\engine\process::status())
			{
				if(isset($result['id']))
				{
					\dash\redirect::to(\dash\url::this(). '/add?id='. \dash\request::get('id'). '&organizer='. $result['id']);
				}
				else
				{
					\dash\redirect::to(\dash\url::this());
				}

			}
		}
	}
}
?>
