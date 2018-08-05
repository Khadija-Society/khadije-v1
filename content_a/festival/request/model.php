<?php
namespace content_a\festival\request;


class model
{
	public static function upload_file($_name)
	{
		if(\dash\request::files($_name))
		{
			$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => $_name]);

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
		\content_a\festival\request\view::config();

		$allowfile = \dash\data::course_allowfile();

		$uploaded_file = [];

		foreach ($allowfile as $key => $value)
		{
			if($key === 'filesize')
			{
				continue;
			}

			if($value === true)
			{
				$uploaded_file[$key] = self::upload_file($key);
				if($uploaded_file[$key] === false)
				{
					return false;
				}

				// if($uploaded_file[$key] === null)
				// {
				// 	\dash\notif::error(T_("Please fill the file"), $key);
				// 	return false;
				// }
			}
		}

		if(empty(array_filter($uploaded_file)))
		{
			\dash\notif::error(T_("Please fill the file"), $key);
			return false;
		}

		$festival_id = \dash\request::get('id');
		$festival_id = \dash\coding::decode($festival_id);
		if(!$festival_id || !is_numeric($festival_id))
		{
			\dash\notif::error(T_("Invalid festival id"));
			return false;
		}

		$check_duplicate =
		[
			'festival_id'       => $festival_id,
			'festivalcourse_id' => \dash\coding::decode(\dash\request::get('course')),
			'user_id'           => \dash\user::id(),
			'limit'             => 1
		];

		$check_duplicate = \lib\db\festivalusers::get($check_duplicate);

		if(isset($check_duplicate['id']))
		{
			$file = json_encode($uploaded_file, JSON_UNESCAPED_UNICODE);
			\lib\db\festivalusers::update(['file' => $file, 'status' => 'awaiting'], $check_duplicate['id']);
			\dash\notif::ok(T_("File successfull send"));
			\dash\session::set('userCompleteCourse', true);
			\dash\redirect::pwd();
			return true;
		}
		else
		{
			\dash\notif::error(T_("You are not register to this course yet"));
			return false;
		}


	}


}
?>
