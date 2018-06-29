<?php
namespace content_fp\festival\detail;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');

		$post             = [];
		$post['intro']    = isset($_POST['intro']) ? $_POST['intro']: null;
		$post['about']    = isset($_POST['about']) ? $_POST['about']: null;
		$post['target']   = isset($_POST['target']) ? $_POST['target']: null;
		$post['axis']     = isset($_POST['axis']) ? $_POST['axis']: null;
		$post['view']     = isset($_POST['view']) ? $_POST['view']: null;
		$post['schedule'] = isset($_POST['schedule']) ? $_POST['schedule']: null;
		$post['place']    = isset($_POST['place']) ? $_POST['place']: null;
		$post['award']    = isset($_POST['award']) ? $_POST['award']: null;

		$result           = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
