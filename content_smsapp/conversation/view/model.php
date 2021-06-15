<?php
namespace content_smsapp\conversation\view;


class model
{
	public static function post()
	{
		if(\dash\request::post('archive') === 'conversation')
		{
			\lib\app\conversation\edit::archive_conversation(\dash\data::myMobile());

			\dash\redirect::to(\dash\url::this());

			return;
		}

		if(\dash\request::post('unblock') === 'mobile')
		{
			$result = \lib\app\smsgroupfilter::remove(\dash\request::post('uid'));

			\dash\redirect::pwd();
			return;

		}


		if(\dash\request::post('answer'))
		{
			$post                = [];
			$post['group_id']    = \dash\request::post('group_id');
			$post['answer']      = \dash\request::post('answer');
			$post['fromgateway'] = \dash\request::post('fromgateway');

			\lib\app\conversation\answer::set_answer($post, \dash\data::myMobile());
			\lib\app\conversation\edit::archive_conversation(\dash\data::myMobile());

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}

			return;
		}

		if(\dash\request::post('block') === 'mobile')
		{
			$post             = [];
			$post['number']     = \dash\data::myMobile();
			$post['type']     = 'number';
			$post['group_id'] = \content_smsapp\editgroup\controller::block_group_id();

			$result = \lib\app\smsgroupfilter::add($post);
			\lib\app\conversation\edit::archive_conversation(\dash\data::myMobile());

			\dash\redirect::to(\dash\url::this());

			return false;
		}


		if(\dash\request::post('secret') === 'mobile')
		{
			$post             = [];
			$post['number']     = \dash\data::myMobile();
			$post['type']     = 'number';
			$post['group_id'] = \content_smsapp\editgroup\controller::secret_group_id();


			$result = \lib\app\smsgroupfilter::add($post);
			\lib\app\conversation\edit::archive_conversation(\dash\data::myMobile());
			\dash\redirect::pwd();

			return false;
		}

	}
}
?>
