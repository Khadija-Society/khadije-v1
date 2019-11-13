<?php
namespace content_m\userkarbala2\l;

class model
{

	public static function post()
	{

		if(\dash\request::post('type') === 'remove' && \dash\request::post('id') && \dash\permission::supervisor())
		{
			\lib\app\lottery::remove(\dash\request::post('id'));
			\dash\redirect::pwd();
			return;
		}

		\dash\permission::access('koyeMohebbatAddLottery');
		$post                  = [];
		$post['title']         = \dash\request::post('title');
		$post['date']          = \dash\request::post('date');
		$post['countall']      = \dash\request::post('countall');
		$post['countperlevel'] = \dash\request::post('countperlevel');
		$post['table']         = 'karbala2users';

		$add_new_lottery = \lib\app\lottery::add($post);

		if($add_new_lottery)
		{
			\dash\redirect::pwd();
		}
	}
}
?>