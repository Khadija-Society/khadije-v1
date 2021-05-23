<?php
namespace content_smsapp\editgroup;


class model
{
	public static function post()
	{
		if(\dash\permission::supervisor() && \dash\request::post('delete') === 'delete' && \dash\request::get('id'))
		{
			\lib\app\smsgroup::remove(\dash\request::get('id'));
			\dash\redirect::to(\dash\url::here(). '/settings');
			return;
		}

		if(\dash\request::post('removeanswer'))
		{
			$result = \lib\app\smsgroupfilter::remove(\dash\request::post('removeanswer'));

			if(\dash\engine\process::status())
			{
				\dash\redirect::to(\dash\url::this(). '?id='. \dash\request::get("id"));
			}

			return;
		}


		if(\dash\request::post('setanswer'))
		{
			$post             = [];
			$post['text']     = \dash\request::post('text');
			$post['sort']     = \dash\request::post('asort');
			$post['type']     = 'answer';
			$post['group_id'] = \dash\request::get('id');

			if(\dash\request::get('aid'))
			{
				$result = \lib\app\smsgroupfilter::edit($post, \dash\request::get('aid'));
			}
			else
			{
				$result = \lib\app\smsgroupfilter::add($post);
			}

			if(\dash\engine\process::status())
			{
				\dash\redirect::to(\dash\url::this(). '?id='. \dash\request::get("id"));
			}

			return;

		}

		$post               = [];
		$post['title']      = \dash\request::post('title');
		// $post['type']    = \dash\request::post('type');
		// $post['analyze'] = \dash\request::post('analyze');
		$post['calcdate']   = \dash\request::post('calcdate');
		$post['status']     = \dash\request::post('status');
		$post['sort']       = \dash\request::post('sort');

		$result = \lib\app\smsgroup::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{

			$result = \lib\app\smsgroupfilter::sync_answer(\dash\request::post('tag'), \dash\request::get('id'));

			\dash\redirect::pwd();
		}
	}
}
?>
