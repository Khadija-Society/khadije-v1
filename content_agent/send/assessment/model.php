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
			if(!is_numeric(substr($key, 5)))
			{
				continue;
			}

			if(substr($key, 0, 5) === 'star_')
			{
				$myStar = (5 - intval($value)) + 1;
				$score += $myStar;
				$star[substr($key, 5)] = $myStar;
			}

			if(substr($key, 0, 5) === 'item_')
			{
				$item[substr($key, 5)] = $value;
			}
		}

		foreach ($item as $key => $value)
		{
			$item_detail = \lib\db\assessmentitem::get(['id' => $key, 'limit' => 1]);
			$item[$key] = $item_detail;
		}


		$send_id = \dash\coding::decode(\dash\request::get('id'));

		$percent = 0;
		$div = 0;

		foreach ($item as $key => $value)
		{
			$rate = 1;
			$myStar = 0;

			if(isset($star[$key]) && is_numeric($star[$key]) && $star[$key])
			{
				$myStar = intval($star[$key]);
			}

			if(isset($item[$key]['rate']) && is_numeric($item[$key]['rate']) && $item[$key]['rate'])
			{
				$rate = intval($item[$key]['rate']);
			}
			$div += ($rate * 5);

			$percent += intval($rate) * intval($myStar);

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
					'star'             => $myStar,
					'rate'             => $rate,
				];
				\lib\db\assessmentdetail::insert($insert);
			}
			else
			{
				\lib\db\assessmentdetail::update(['star' => $myStar, 'rate' => $rate], $get['id']);
			}
		}

		if(!$div)
		{
			$div = 1;
		}
		$score = $percent;
		$percent = round(($percent * 100) / $div);

		$update_send =
		[
			'assessmentdate' => date("Y-m-d H:i:s"),
			'assessmentor'   => \dash\user::id(),
			'assessmentdesc' => \dash\request::post('desc'),
			'score'          => $score,
			'percent'        => $percent,
		];

		\lib\app\send::edit($update_send, \dash\request::get('id'));


		if(\dash\engine\process::status())
		{

			\dash\redirect::to(\dash\url::pwd());
		}
	}
}
?>