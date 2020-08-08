<?php
namespace content_a\protection\occasion;


class model
{
	// public static function upload_file($_name)
	// {
	// 	if(\dash\request::files($_name))
	// 	{
	// 		$uploaded_file = \dash\app\file::upload(['debug' => false, 'upload_name' => $_name]);

	// 		if(isset($uploaded_file['url']))
	// 		{
	// 			\dash\notif::direct();

	// 			return $uploaded_file['url'];
	// 		}
	// 		// if in upload have error return
	// 		if(!\dash\engine\process::status())
	// 		{
	// 			return false;
	// 		}
	// 	}
	// 	return null;
	// }

	public static function post()
	{

		var_dump(\dash\request::post());exit();
		$check_duplicate =
		[
			'festival_id'       => $festival_id,
			'festivalcourse_id' => \dash\coding::decode(\dash\request::get('course')),
			'user_id'           => \dash\user::id(),
			'limit'             => 1
		];

		$check_duplicate = \lib\db\festivalusers::get($check_duplicate);
		if(isset($check_duplicate['id']) && isset($check_duplicate['status']))
		{
			if(!in_array($check_duplicate['status'], ['draft', 'awaiting']))
			{
				\dash\notif::error(T_("You can not update your file"));
				return false;
			}

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
