<?php
namespace content_agent\send\summary;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title("خلاصه ارزیابی");

		\dash\data::page_pictogram('atom');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back'));


		self::summary();

	}



	private static function summary()
	{
		$send_id = \dash\request::get('id');
		$send_id = \dash\coding::decode($send_id);
		if(!$send_id)
		{
			return false;
		}



		$load_assessment = \lib\db\assessment::get_avg_group($send_id);
		$load_assessment_detail = \lib\db\assessment::get_avg_group_detail($send_id);
		if(!is_array($load_assessment))
		{
			$load_assessment = [];
		}

		$load_assessment = array_map(['\\dash\\app', 'ready'], $load_assessment);
		$load_assessment = array_combine(array_column($load_assessment, 'assessment_for'), $load_assessment);

		$load_assessment_detail = array_map(['\\dash\\app', 'ready'], $load_assessment_detail);

		foreach ($load_assessment_detail as $key => $value)
		{
			if(!isset($load_assessment[$value['assessment_for']]['detail']))
			{
				$load_assessment[$value['assessment_for']]['detail'] = [];
			}

			$load_assessment[$value['assessment_for']]['detail'][] = $value;
		}

		$jobList =
		[
			'admin'       => 'مدیر کاروان',
			'adminoffice' => 'مسئول زائرسرا',
			'servant'     => 'نگهبان',
			'clergy'      => 'روحانی',
			'missionary'  => 'مبلغ',

		];

		foreach ($load_assessment as $key => $value)
		{
			if(isset($value['job']) && isset($jobList[$value['job']]))
			{
				$load_assessment[$key]['job'] = $jobList[$value['job']];
			}
		}

		\dash\data::summaryList($load_assessment);

	}
}
?>