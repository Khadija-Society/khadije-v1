<?php
namespace content_fp\festival\detail;


class model
{
	public static function post()
	{
		\dash\permission::access('fpFestivalAdd');

		$post             = [];
		if(isset($_POST['intro'])) $post['intro'] = $_POST['intro'];
		if(isset($_POST['about'])) $post['about'] = $_POST['about'];
		if(isset($_POST['target'])) $post['target'] = $_POST['target'];
		if(isset($_POST['axis'])) $post['axis'] = $_POST['axis'];
		if(isset($_POST['view'])) $post['view'] = $_POST['view'];
		if(isset($_POST['schedule'])) $post['schedule'] = $_POST['schedule'];
		if(isset($_POST['place'])) $post['place'] = $_POST['place'];
		if(isset($_POST['award'])) $post['award'] = $_POST['award'];

		$result           = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
