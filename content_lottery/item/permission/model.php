<?php
namespace content_lottery\item\permission;


class model
{
	public static function post()
	{
		$perm    = [];
		$allpost = \dash\request::post();
		foreach ($allpost as $key => $value)
		{
			if(substr($key, 0, 5) === 'perm_')
			{
				$perm[] = substr($key, 5);
			}
		}

		$post['permission'] = json_encode($perm, JSON_UNESCAPED_UNICODE);


		\lib\app\syslottery::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
			\dash\redirect::to(\dash\url::here(). '/item'. \dash\data::xTypeStart());
		}

	}
}
?>