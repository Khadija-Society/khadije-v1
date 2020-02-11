<?php
namespace content_lottery\user\l;

class model
{

	public static function post()
	{

		if(\dash\request::post('type') === 'remove' && \dash\request::post('id') && \dash\permission::supervisor())
		{
			\lib\app\lotterywin::remove(\dash\request::post('id'));
			\dash\redirect::pwd();
			return;
		}


		$post                  = [];
		$post['title']         = \dash\request::post('title');
		$post['date']          = \dash\request::post('date');
		$post['countall']      = \dash\request::post('countall');
		$post['countperlevel'] = \dash\request::post('countperlevel');
		$post['table']         = 'karbala2users';

		$add_new_lottery = \lib\app\lotterywin::add($post);

		if($add_new_lottery)
		{
			\dash\redirect::pwd();
		}
	}
}
?>