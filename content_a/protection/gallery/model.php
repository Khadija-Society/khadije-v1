<?php
namespace content_a\protection\gallery;


class model
{

	public static function post()
	{
		$field = \dash\request::post('field');

		$post =
		[
			'occation_id'               => \dash\data::occasionID(),
			'protectionagetnoccasionid' => \dash\request::get('id'),
		];

		if(\dash\request::post('remove') === 'remove')
		{
			$key = \dash\request::post('key');
			$post['file_remove_key'] = $key;

			$reault = \lib\app\protectionagentoccasion::edit_gallery($post, 'remove', $field);
			\dash\redirect::pwd();
		}

		$field = $_FILES;
		$field = array_keys($field);
		$field = array_values($field);
		if(a($field, 0))
		{
			$field = $field[0];
		}
		else
		{
			\dash\notif::error(T_("No file uploaded"));
			return false;
		}

		$file = \dash\app\file::upload_quick($field);
		if($file)
		{
			$post['file_new'] = $file;

			$reault = \lib\app\protectionagentoccasion::edit_gallery($post, 'add', $field);

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
