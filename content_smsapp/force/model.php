<?php
namespace content_smsapp\force;


class model
{
	public static function post()
	{
		if(!\dash\request::post('run'))
		{
			return false;
		}

		$iwanttoanswer = \dash\request::post('iwanttoanswer');
		$answer        = \dash\request::post('answer');

		if($iwanttoanswer && !$answer)
		{
			\dash\notif::error("لطفا متن پیام را وارد کنید", 'answer');
			return false;
		}

		$new_list_args =
		[
			'sendstatus'    => null,
			'receivestatus' => 'awaiting',
			'recommend_id'  => null,
			'group_id'      => null,
		];

		if(\dash\request::post('answerdate'))
		{
			$startdate = \dash\request::post('startdate');
			$enddate   = \dash\request::post('enddate');

			$startdate = \dash\date::db($startdate);
			$enddate   = \dash\date::db($enddate);

			if($startdate)
			{
				if(\dash\utility\jdate::is_jalali($startdate))
				{
					$startdate = \dash\utility\jdate::to_gregorian($startdate);
				}
			}

			if($enddate)
			{
				if(\dash\utility\jdate::is_jalali($enddate))
				{
					$enddate = \dash\utility\jdate::to_gregorian($enddate);
				}
			}

			if(!$startdate || !$enddate)
			{
				\dash\notif::error("لطفا تاریخ شروع و پایان را وارد کنید", ['element' => ['startdate', 'enddate']]);
				return false;
			}

			$new_list_args['1.1'] = [' = 1.1', " AND DATE(s_sms.date) >= DATE('$startdate') "];
			$new_list_args['2.2'] = [' = 2.2', " AND DATE(s_sms.date) <= DATE('$enddate') "];
		}


		$new_list_count = \dash\db\config::public_get_count('s_sms', $new_list_args);

		if(!$new_list_count)
		{
			\dash\notif::error("شما هیچ پیام جدید شناسایی نشده ای ندارید");
			return false;
		}

		$post                  = [];
		$post['group_id']      = null;
		$post['dateanswer']    = date("Y-m-d H:i:s");

		if($answer)
		{
			$post['answertext']    = $answer;
			$post['sendstatus']    = 'awaiting';
			$post['receivestatus'] = 'sendtopanel';
		}
		else
		{

			$post['answertext']    = null;
			$post['sendstatus']    = null;
			$post['receivestatus'] = 'skip';

		}

		$result = \dash\db\config::public_update_where('s_sms', $post, $new_list_args);

		\dash\notif::ok("عملیات بر روی ". \dash\fit::number($new_list_count). ' پیامک کامل شد');
		\dash\redirect::pwd();
		return;

	}
}
?>
