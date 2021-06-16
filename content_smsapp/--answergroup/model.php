<?php
namespace content_smsapp\answergroup;


class model
{
	public static function post()
	{
		if(\dash\request::post('type') === 'isdefault')
		{
			if(\lib\app\smsgroupfilter::set_answer_default(\dash\request::post('defaultid'), \dash\request::post('group_id')))
			{
				\dash\notif::ok(T_("Default is set"));
				\dash\redirect::pwd();
			}
			return;
		}
		if(\dash\request::post('type') === 'removedefault')
		{
			if(\lib\app\smsgroupfilter::remove_answer_default(\dash\request::post('defaultid'), \dash\request::post('group_id')))
			{
				\dash\notif::ok(T_("Default is removed"));
				\dash\redirect::pwd();
			}
			return;
		}

		if(\dash\request::post('type') === 'isdefaultpanel')
		{
			if(\lib\app\smsgroupfilter::set_answer_default(\dash\request::post('defaultid'), \dash\request::post('group_id'), true))
			{
				\dash\notif::ok(T_("Default is set"));
				\dash\redirect::pwd();
			}
			return;
		}
		if(\dash\request::post('type') === 'removedefaultpanel')
		{
			if(\lib\app\smsgroupfilter::remove_answer_default(\dash\request::post('defaultid'), \dash\request::post('group_id'), true))
			{
				\dash\notif::ok(T_("Default is removed"));
				\dash\redirect::pwd();
			}
			return;
		}

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
		$post['type']     = 'answer';
		$post['group_id'] = \dash\request::get('id');

		$result = \lib\app\smsgroupfilter::add($post);

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}
	}
}
?>
