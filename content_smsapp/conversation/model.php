<?php
namespace content_smsapp\conversation;


class model
{
	public static function post()
	{
		if(\dash\request::post('archive') === 'conversation')
		{
			\lib\app\conversation\edit::archive_conversation(\dash\request::post('mobile'));

			\dash\redirect::pwd();

			return;
		}
		$status = \dash\request::post('status');

		if($status === 'change')
		{
			$myStatus = \lib\app\sms::status();
			if($myStatus)
			{
				$myStatus = \lib\app\sms::status(false);
				\dash\notif::warn(T_("Power off"));
			}
			else
			{
				$myStatus = \lib\app\sms::status(true);
				\dash\notif::ok(T_("Power on"));
			}

			\dash\redirect::pwd();
		}



		return;































		$allGet = \dash\request::get();
		unset($allGet['page']);
		unset($allGet['recommend']);
		\dash\data::archiveBTN($allGet);


		if(\dash\request::post('archive') === 'all' && !\dash\data::archiveBTN())
		{

			// \dash\temp::set('no-limit', true);
			// \content_smsapp\listsms\view::config();
			// $list = \dash\data::dataTable();
			$list = \dash\request::post('archive_id');
			if(!$list)
			{
				\dash\notif::error("لطفا ابتدا انتخاب کنید که کدام پیامک بایگانی شود");
				return false;
			}

			if($list && is_array($list))
			{
				// $ids = array_column($list, 'id');
				$ids = array_map(['\\dash\\coding', 'decode'], $list);
				$ids = array_filter($ids);
				$ids = array_unique($ids);

				if($ids)
				{

					$post                  = [];
					$post['group_id']      = null;
					$post['answertext']    = null;
					$post['sendstatus']    = null;
					$post['dateanswer']    = date("Y-m-d H:i:s");
					$post['receivestatus'] = 'skip';

					$result = \lib\app\sms::edit_multi($post, $ids);

					\dash\notif::ok("همه پیام‌ها آرشیو شدند");
					\dash\redirect::pwd();
					return;
				}
			}

			\dash\notif::info("هیچ پیامی برای بایگانی یافت نشد!");

			return;
		}

		if(\dash\request::post('type') === 'setAnswer')
		{
			$answer_id    = \dash\request::post('answer_id');
			$recommend_id = \dash\request::post('recommend_id');
			$fromgateway  = \dash\request::post('fromgateway');
			// from_sender
			// from_smspanel
			if(!$answer_id)
			{
				\dash\notif::error(T_("Please choose one answer"));
				return false;
			}
			\lib\app\sms::recommend_answer($recommend_id, $answer_id, $fromgateway);
			\dash\notif::ok(T_("All message group saved"));
			\dash\redirect::pwd();
			return;
		}

		if(\dash\request::post('recommend') === 'invalid')
		{
			$post                 = [];
			$post['recommend_id'] = null;
			$result               = \lib\app\sms::edit($post, \dash\request::post('id'));
			\dash\redirect::pwd();
			return;
		}

		if(\dash\request::post('skip') === 'skip')
		{
			$post                  = [];
			$post['group_id']      = null;
			$post['answertext']    = null;
			$post['sendstatus']    = null;
			$post['dateanswer']    = date("Y-m-d H:i:s");
			$post['receivestatus'] = 'skip';

			$result = \lib\app\sms::edit($post, \dash\request::post('id'));

			\dash\redirect::pwd();
			return;
		}
		$status = \dash\request::post('status');

		if($status === 'change')
		{
			$myStatus = \lib\app\sms::status();
			if($myStatus)
			{
				$myStatus = \lib\app\sms::status(false);
			}
			else
			{
				$myStatus = \lib\app\sms::status(true);
			}

			\dash\redirect::pwd();
		}

	}
}
?>
