<?php
namespace content_agent\send\assessment;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title("جزئیات ارزیابی");

		\dash\data::page_pictogram('search');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back'));

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back'));


		self::load_assessment_list();

	}



	private static function load_assessment_list()
	{
		$send_id = \dash\request::get('id');
		$send_id = \dash\coding::decode($send_id);
		if(!$send_id)
		{
			return false;
		}

		$sort =
		[

			'adminoffice' =>
			[
				'title' => 'مسئول زائرسرا',
				'list' =>
				[
					'adminoffice_admin'      => ['ejob' => 'adminoffice', 'ejob_for' => 'admin', "job" => "مسئول زائرسرا", 'job_for' => 'مدیر کاروان', 'data' => []],
					'adminoffice_missionary' => ['ejob' => 'adminoffice', 'ejob_for' => 'missionary', "job" => "مسئول زائرسرا", 'job_for' => 'مبلغ', 'data' => []],
					'adminoffice_servant'    => ['ejob' => 'adminoffice', 'ejob_for' => 'servant', "job" => "مسئول زائرسرا", 'job_for' => 'نگهبان', 'data' => []],
				],
			],

			'admin' =>
			[
				'title' => 'مدیر کاروان',
				'list' =>
				[
					'admin_adminoffice'      => ['ejob' => 'admin', 'ejob_for' => 'adminoffice', "job" => "مدیر کاروان", 'job_for' => 'مسئول زائرسرا', 'data' => []],
					'admin_missionary'       => ['ejob' => 'admin', 'ejob_for' => 'missionary', "job" => "مدیر کاروان", 'job_for' => 'مبلغ', 'data' => []],
					'admin_servant'          => ['ejob' => 'admin', 'ejob_for' => 'servant', "job" => "مدیر کاروان", 'job_for' => 'نگهبان', 'data' => []],
				],
			],

			'missionary' =>
			[
				'title' => 'مبلغ',
				'list' =>
				[
					'missionary_admin'       => ['ejob' => 'missionary', 'ejob_for' => 'admin', "job" => "مبلغ", 'job_for' => 'مدیر کاروان', 'data' => []],
					'missionary_adminoffice' => ['ejob' => 'missionary', 'ejob_for' => 'adminoffice', "job" => "مبلغ", 'job_for' => 'مسئول زائرسرا', 'data' => []],
					'missionary_servant'     => ['ejob' => 'missionary', 'ejob_for' => 'servant', "job" => "مبلغ", 'job_for' => 'نگهبان', 'data' => []],
				],
			],

			'servant' =>
			[
				'title' => 'نگهبان',
				'list' =>
				[
					'servant_admin'          => ['ejob' => 'servant', 'ejob_for' => 'admin', "job" => "نگهبان", 'job_for' => 'مدیر کاروان', 'data' => []],
					'servant_missionary'     => ['ejob' => 'servant', 'ejob_for' => 'missionary', "job" => "نگهبان", 'job_for' => 'مبلغ', 'data' => []],
					'servant_adminoffice'    => ['ejob' => 'servant', 'ejob_for' => 'adminoffice', "job" => "نگهبان", 'job_for' => 'مسئول زائرسرا', 'data' => []],
				],
			],

		];

		$load_assessment = \lib\db\assessment::get(['agent_assessment.send_id' => $send_id]);

		foreach ($load_assessment as $key => $value)
		{
			$myKey = $value['job']. '_'. $value['job_for'];
			if(isset($sort[$value['job']]['list'][$myKey]))
			{
				$sort[$value['job']]['list'][$myKey]['data'] = $value;
			}
		}

		\dash\data::assessmentList($sort);

	}
}
?>