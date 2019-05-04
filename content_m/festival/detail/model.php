<?php
namespace content_m\festival\detail;


class model
{
	public static function post()
	{

		$post             = [];
		if(isset($_POST['intro'])) $post['intro'] = $_POST['intro'];
		if(isset($_POST['about'])) $post['about'] = $_POST['about'];
		if(isset($_POST['target'])) $post['target'] = $_POST['target'];
		if(isset($_POST['axis'])) $post['axis'] = $_POST['axis'];
		if(isset($_POST['view'])) $post['view'] = $_POST['view'];
		if(isset($_POST['place'])) $post['place'] = $_POST['place'];
		if(isset($_POST['award'])) $post['award'] = $_POST['award'];

		foreach ($post as $key => $value)
		{
			$test = $value;
			$test = strip_tags($test);
			$test = htmlspecialchars_decode($test);
			$test = str_replace("&nbsp;"," ",$test);
			$test = trim($test);

			if(!$test)
			{
				$post[$key] = null;
			}
		}
		$result           = \lib\app\festival::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
