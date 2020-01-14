<?php
namespace content_agent\send\assessment;


class model
{
	public static function post()
	{

		$post = \dash\request::post();

		$star = [];
		$item = [];
		$score = 0;
		foreach ($post as $key => $value)
		{
			if(substr($key, 0, 5) === 'star_')
			{
				if(!is_numeric(substr($key, 5)))
				{
					continue;
				}

				$myStar = (5 - intval($value)) + 1;
				$score += $myStar;
				$star[substr($key, 5)] = $myStar;
			}

			if(substr($key, 0, 5) === 'item_')
			{
				$item[substr($key, 5)] = $value;
			}
		}

		$send_id = \dash\coding::decode(\dash\request::get('id'));

		foreach ($star as $key => $value)
		{
			$get =
			[
				'agent_send_id'     => $send_id,
				'assessmentitem_id' => $key,
				'limit'             => 1
			];
			$get = \lib\db\assessmentdetail::get($get);
			if(!isset($get['id']))
			{
				$insert =
				[
					'agent_send_id'     => $send_id,
					'assessmentitem_id' => $key,
					'star'             => $value,
				];
				\lib\db\assessmentdetail::insert($insert);
			}
			else
			{
				\lib\db\assessmentdetail::update(['star' => $value], $get['id']);
			}
		}

		$update_send =
		[
			'assessmentdate' => date("Y-m-d H:i:s"),
			'assessmentor'   => \dash\user::id(),
			'assessmentdesc' => \dash\request::post('desc'),
			'score'          => $score,
		];

		\lib\app\send::edit($update_send, \dash\request::get('id'));


		if(\dash\engine\process::status())
		{

			\dash\redirect::to(\dash\url::pwd());
		}
	}
}
?>