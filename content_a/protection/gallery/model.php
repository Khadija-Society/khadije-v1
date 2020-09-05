<?php
namespace content_a\protection\gallery;


class model
{

	public static function post()
	{
		$post =
		[
			'occation_id'               => \dash\data::occasionID(),
			'protectionagetnoccasionid' => \dash\request::get('id'),
		];

		if(\dash\request::post('remove') === 'remove')
		{
			$key = \dash\request::post('key');
			$post['file_remove_key'] = $key;

			$reault = \lib\app\protectionagentoccasion::edit_gallery($post, 'remove');
			\dash\redirect::pwd();
		}


		$file = \dash\app\file::upload_quick('image');
		if($file)
		{
			$post['file_new'] = $file;

			$reault = \lib\app\protectionagentoccasion::edit_gallery($post, 'add');

			\dash\redirect::pwd();

		}
		else
		{
			\dash\notif::warn(T_("No file was send"));
			return false;
		}
	}
}
?>
