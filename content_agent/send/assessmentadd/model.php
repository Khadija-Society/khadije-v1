<?php
namespace content_agent\send\assessmentadd;


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

		if(count($star) !== count($item))
		{
			\dash\notif::error("لطفا به همه گزینه‌ها پاسخ دهید");
			return false;
		}


		$send_id = \dash\coding::decode(\dash\request::get('id'));

		$assessmentor = \dash\request::post('assessmentor');
		$assessmentor = \dash\coding::decode($assessmentor);

		$assessment_for = \dash\request::post('assessment_for');
		$assessment_for = \dash\coding::decode($assessment_for);

		$job = \dash\request::post('job');
		$job_for = \dash\request::post('job_for');


		if($job && !in_array($job, ['clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah','rabet', 'nazer', 'khadem', 'khadem2']))
		{
			\dash\notif::error(T_("Invalid data"));
			return false;
		}

		if($job_for && !in_array($job_for, ['clergy', 'admin', 'adminoffice', 'missionary', 'servant', 'maddah','rabet', 'nazer', 'khadem', 'khadem2']))
		{
			\dash\notif::error(T_("Invalid data"));
			return false;
		}


		$assessment                   = [];
		$assessment['send_id']        = $send_id;
		$assessment['creator']        = \dash\user::id();
		$assessment['assessmentdate'] = date("Y-m-d H:i:s");
		$assessment['assessmentdesc'] = \dash\request::post('desc');
		$assessment['score']          = null;
		$assessment['percent']        = null;
		$assessment['datecreated']    = date("Y-m-d H:i:s");
		$assessment['assessmentor']   = $assessmentor;
		$assessment['assessment_for'] = $assessment_for;
		$assessment['job']            = $job;
		$assessment['job_for']        = $job_for;


		$assessment_id = null;

		if(\dash\request::get('assessment_id'))
		{
			$assessment_id = \dash\request::get('assessment_id');
			$assessment_id = \dash\coding::decode($assessment_id);
			if(!$assessment_id)
			{
				\dash\notif::error(T_("Invalid assessment id"));
				return false;
			}
		}
		else
		{
			if(!$assessment['assessmentor'])
			{
				\dash\notif::error(T_("assessmentor not found"));
				return false;
			}

			if(!$assessment['assessment_for'])
			{
				\dash\notif::error(T_("assessment_for not found"));
				return false;
			}

			if(!$assessment['job'])
			{
				\dash\notif::error(T_("job not found"));
				return false;
			}

			if(!$assessment['job_for'])
			{
				\dash\notif::error(T_("for job not found"));
				return false;
			}

			$check_assessment_detail =
			[
				'assessmentor'   => $assessment['assessmentor'],
				'assessment_for' => $assessment['assessment_for'],
				'send_id'        => $assessment['send_id'],
				'limit'          => 1,
			];

			$check_assessment_detail = \lib\db\assessment::get($check_assessment_detail);
			if(isset($check_assessment_detail['id']))
			{
				$assessment_id = $check_assessment_detail['id'];
			}
			else
			{
				$assessment_id = \lib\db\assessment::insert($assessment);
			}
		}

		if(!$assessment_id)
		{
			\dash\notif::error(T_("Can not add assessment"));
			return false;
		}


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
				'assessment_id'     => $assessment_id,
				'assessmentitem_id' => $key,
				'limit'             => 1
			];
			$get = \lib\db\assessmentdetail::get($get);
			if(!isset($get['id']))
			{
				$insert =
				[
					'agent_send_id'     => $send_id,
					'assessment_id'     => $assessment_id,
					'assessmentitem_id' => $key,
					'star'              => $myStar,
					'rate'              => $rate,
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

		$update_assessment =
		[
			'assessmentdate' => date("Y-m-d H:i:s"),
			'assessmentdesc' => \dash\request::post('desc'),
			'score'          => $score,
			'percent'        => $percent,
		];

		\lib\db\assessment::update($update_assessment, $assessment_id);


		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Data saved"));
			\dash\redirect::to(\dash\url::that(). '?id='. \dash\request::get('id'). '&assessment_id='. \dash\coding::encode($assessment_id). \dash\data::xCityAnd());
		}
	}
}
?>