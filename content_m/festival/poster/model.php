<?php
namespace content_m\festival\poster;


class model
{
	public static function upload_poster()
	{
		if(\dash\request::files('poster'))
		{
			$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => 'poster']);

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
		$file = self::upload_poster();
		if($file === false)
		{
			return false;
		}

		$post = [];
		$old  = \dash\data::dataRow_gallery();

		if(!is_array($old))
		{
			$old = json_decode($old, true);
		}

		if(!is_array($old))
		{
			$old = [];
		}

		if($file)
		{
			$old['poster']   = $file;
			$post['gallery'] = json_encode($old, JSON_UNESCAPED_UNICODE);
			$result          = \lib\app\festival::edit($post, \dash\request::get('id'));
		}


		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
