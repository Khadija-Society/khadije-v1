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

		$post            = [];
		$post['title']   = \dash\request::post('title');
		// $post['type']    = \dash\request::post('type');
		// $post['analyze'] = \dash\request::post('analyze');
		// $post['ismoney'] = \dash\request::post('ismoney');
		$post['status']  = \dash\request::post('status');
		$post['sort']  = \dash\request::post('sort');

		$result = \lib\app\smsgroup::edit($post, \dash\request::get('id'));

		if(\dash\engine\process::status())
		{
			var_dump($_POST);exit();
			if(\dash\request::post('type') === 'remove')
			{
				if(\lib\app\smsgroupfilter::remove(\dash\request::post('deleteid')))
				{
					\dash\notif::ok(T_("Filter removed"));
					\dash\redirect::pwd();
				}
				return;
			}

			$post             = [];
			$post['text']     = \dash\request::post('text');
			$post['type']     = 'analyze';
			$post['group_id'] = \dash\request::get('id');

			$result = \lib\app\smsgroupfilter::add($post);

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}


			\dash\redirect::pwd();
		}
	}
}
?>
