<?php
namespace content_smsapp\editgroup;


class model
{
	public static function post()
	{
		if(\dash\request::post('analyze') === 'group')
		{
			\lib\app\smsgroupfilter::add_new_filter(\dash\coding::decode(\dash\data::myId()));
			\dash\notif::ok('درخواست انجام شد');
			\dash\redirect::pwd();

			return;
		}


		if(\dash\permission::supervisor() && \dash\request::post('delete') === 'delete' && \dash\data::myId())
		{
			\lib\app\smsgroup::remove(\dash\data::myId());
			\dash\redirect::to(\dash\url::here(). '/settings'. \dash\data::platoonGet());
			return;
		}

		if(\dash\request::post('removeanswer'))
		{
			$result = \lib\app\smsgroupfilter::remove(\dash\request::post('removeanswer'));

			if(\dash\engine\process::status())
			{
				if(\dash\data::blockMode() || \dash\data::secretMode())
				{
					\dash\redirect::pwd();
				}
				else
				{
					\dash\redirect::to(\dash\url::this(). '?id='. \dash\data::myId(). \dash\data::platoonGetAnd());
				}
			}

			return;
		}


		if(\dash\request::post('setblock'))
		{
			$post             = [];
			$post['number']     = \dash\request::post('abn');
			$post['type']     = 'number';
			$post['platoon'] = \lib\app\platoon\tools::get_index_locked();
			$post['group_id'] = \dash\data::myId();

			$result = \lib\app\smsgroupfilter::add($post);

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}

			return;

		}


		if(\dash\request::post('setanswer'))
		{
			$post             = [];
			$post['text']     = \dash\request::post('text');
			$post['sort']     = \dash\request::post('asort');
			$post['type']     = 'answer';
			$post['platoon'] = \lib\app\platoon\tools::get_index_locked();
			$post['group_id'] = \dash\data::myId();

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
				\dash\redirect::to(\dash\url::this(). '?id='. \dash\data::myId() . \dash\data::platoonGetAnd());
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
		$post['platoon'] = \lib\app\platoon\tools::get_index_locked();

		$result = \lib\app\smsgroup::edit($post, \dash\data::myId());

		if(\dash\engine\process::status())
		{

			$result = \lib\app\smsgroupfilter::sync_answer(\dash\request::post('tag'), \dash\data::myId());

			\dash\redirect::pwd();
		}
	}
}
?>
