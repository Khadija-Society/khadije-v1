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
					'adminoffice_clergy'     => ['ejob' => 'adminoffice', 'ejob_for' => 'clergy', "job" => "مسئول زائرسرا", 'job_for' => 'روحانی کاروان', 'data' => []],
					'adminoffice_nazer'      => ['ejob' => 'adminoffice', 'ejob_for' => 'nazer', "job" => "مسئول زائرسرا", 'job_for' => 'ناظر', 'data' => []],
					'adminoffice_maddah'     => ['ejob' => 'adminoffice', 'ejob_for' => 'maddah', "job" => "مسئول زائرسرا", 'job_for' => 'مداح', 'data' => []],
					'adminoffice_khadem'     => ['ejob' => 'adminoffice', 'ejob_for' => 'khadem', "job" => "مسئول زائرسرا", 'job_for' => 'خادم', 'data' => []],
					'adminoffice_khadem2'    => ['ejob' => 'adminoffice', 'ejob_for' => 'khadem2', "job" => "مسئول زائرسرا", 'job_for' => 'خادم ۲', 'data' => []],
				],
			],

			'admin' =>
			[
				'title' => 'مدیر کاروان',
				'list' =>
				[
					'admin_adminoffice' => ['ejob' => 'admin', 'ejob_for' => 'adminoffice', "job" => "مدیر کاروان", 'job_for' => 'مسئول زائرسرا', 'data' => []],
					'admin_missionary'  => ['ejob' => 'admin', 'ejob_for' => 'missionary', "job" => "مدیر کاروان", 'job_for' => 'مبلغ', 'data' => []],
					'admin_servant'     => ['ejob' => 'admin', 'ejob_for' => 'servant', "job" => "مدیر کاروان", 'job_for' => 'نگهبان', 'data' => []],
					'admin_clergy'      => ['ejob' => 'admin', 'ejob_for' => 'clergy', "job" => "مدیر کاروان", 'job_for' => 'روحانی کاروان', 'data' => []],
					'admin_nazer'       => ['ejob' => 'admin', 'ejob_for' => 'nazer', "job" => "مدیر کاروان", 'job_for' => 'ناظر', 'data' => []],
					'admin_maddah'      => ['ejob' => 'admin', 'ejob_for' => 'maddah', "job" => "مدیر کاروان", 'job_for' => 'مداح', 'data' => []],
					'admin_khadem'      => ['ejob' => 'admin', 'ejob_for' => 'khadem', "job" => "مدیر کاروان", 'job_for' => 'خادم', 'data' => []],
					'admin_khadem2'     => ['ejob' => 'admin', 'ejob_for' => 'khadem2', "job" => "مدیر کاروان", 'job_for' => 'خادم ۲', 'data' => []],
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
					'missionary_clergy'      => ['ejob' => 'missionary', 'ejob_for' => 'clergy', "job" => "مبلغ", 'job_for' => 'روحانی کاروان', 'data' => []],
					'missionary_nazer'       => ['ejob' => 'missionary', 'ejob_for' => 'nazer', "job" => "مبلغ", 'job_for' => 'ناظر', 'data' => []],
					'missionary_maddah'      => ['ejob' => 'missionary', 'ejob_for' => 'maddah', "job" => "مبلغ", 'job_for' => 'مداح', 'data' => []],
					'missionary_khadem'      => ['ejob' => 'missionary', 'ejob_for' => 'khadem', "job" => "مبلغ", 'job_for' => 'خادم', 'data' => []],
					'missionary_khadem2'     => ['ejob' => 'missionary', 'ejob_for' => 'khadem2', "job" => "مبلغ", 'job_for' => 'خادم ۲', 'data' => []],
				],
			],


			'clergy' =>
			[
				'title' => 'روحانی',
				'list' =>
				[
					'clergy_admin'       => ['ejob' => 'clergy', 'ejob_for' => 'admin', "job" => "روحانی", 'job_for' => 'مدیر کاروان', 'data' => []],
					'clergy_missionary'  => ['ejob' => 'clergy', 'ejob_for' => 'missionary', "job" => "روحانی", 'job_for' => 'مبلغ', 'data' => []],
					'clergy_servant'     => ['ejob' => 'clergy', 'ejob_for' => 'servant', "job" => "روحانی", 'job_for' => 'نگهبان', 'data' => []],
					'clergy_adminoffice' => ['ejob' => 'clergy', 'ejob_for' => 'adminoffice', "job" => "روحانی", 'job_for' => 'مسئول زائرسرا', 'data' => []],
					'clergy_nazer'       => ['ejob' => 'clergy', 'ejob_for' => 'nazer', "job" => "روحانی", 'job_for' => 'ناظر', 'data' => []],
					'clergy_maddah'      => ['ejob' => 'clergy', 'ejob_for' => 'maddah', "job" => "روحانی", 'job_for' => 'مداح', 'data' => []],
					'clergy_khadem'      => ['ejob' => 'clergy', 'ejob_for' => 'khadem', "job" => "روحانی", 'job_for' => 'خادم', 'data' => []],
					'clergy_khadem2'     => ['ejob' => 'clergy', 'ejob_for' => 'khadem2', "job" => "روحانی", 'job_for' => 'خادم ۲', 'data' => []],
				],
			],


			'nazer' =>
			[
				'title' => 'ناظر',
				'list' =>
				[
					'nazer_admin'       => ['ejob' => 'nazer', 'ejob_for' => 'admin', "job" => "ناظر", 'job_for' => 'مدیر کاروان', 'data' => []],
					'nazer_missionary'  => ['ejob' => 'nazer', 'ejob_for' => 'missionary', "job" => "ناظر", 'job_for' => 'مبلغ', 'data' => []],
					'nazer_servant'     => ['ejob' => 'nazer', 'ejob_for' => 'servant', "job" => "ناظر", 'job_for' => 'نگهبان', 'data' => []],
					'nazer_adminoffice' => ['ejob' => 'nazer', 'ejob_for' => 'adminoffice', "job" => "ناظر", 'job_for' => 'روحانی کاروان', 'data' => []],
					'nazer_clergy'      => ['ejob' => 'nazer', 'ejob_for' => 'clergy', "job" => "ناظر", 'job_for' => 'مسئول زائرسرا', 'data' => []],
					'nazer_maddah'      => ['ejob' => 'nazer', 'ejob_for' => 'maddah', "job" => "ناظر", 'job_for' => 'مداح', 'data' => []],
					'nazer_khadem'      => ['ejob' => 'nazer', 'ejob_for' => 'khadem', "job" => "ناظر", 'job_for' => 'خادم', 'data' => []],
					'nazer_khadem2'     => ['ejob' => 'nazer', 'ejob_for' => 'khadem2', "job" => "ناظر", 'job_for' => 'خادم ۲', 'data' => []],
				],
			],

			'maddah' =>
			[
				'title' => 'مداح',
				'list' =>
				[
					'maddah_admin'       => ['ejob' => 'maddah', 'ejob_for' => 'admin', "job" => "مداح", 'job_for' => 'مدیر کاروان', 'data' => []],
					'maddah_missionary'  => ['ejob' => 'maddah', 'ejob_for' => 'missionary', "job" => "مداح", 'job_for' => 'مبلغ', 'data' => []],
					'maddah_servant'     => ['ejob' => 'maddah', 'ejob_for' => 'servant', "job" => "مداح", 'job_for' => 'نگهبان', 'data' => []],
					'maddah_adminoffice' => ['ejob' => 'maddah', 'ejob_for' => 'adminoffice', "job" => "مداح", 'job_for' => 'روحانی کاروان', 'data' => []],
					'maddah_nazer'       => ['ejob' => 'maddah', 'ejob_for' => 'nazer', "job" => "مداح", 'job_for' => 'ناظر', 'data' => []],
					'maddah_clergy'      => ['ejob' => 'maddah', 'ejob_for' => 'clergy', "job" => "مداح", 'job_for' => 'مسئول زائرسرا', 'data' => []],
					'maddah_khadem'      => ['ejob' => 'maddah', 'ejob_for' => 'khadem', "job" => "مداح", 'job_for' => 'خادم', 'data' => []],
					'maddah_khadem2'     => ['ejob' => 'maddah', 'ejob_for' => 'khadem2', "job" => "مداح", 'job_for' => 'خادم ۲', 'data' => []],
				],
			],

			'khadem' =>
			[
				'title' => 'خادم',
				'list' =>
				[
					'khadem_admin'       => ['ejob' => 'khadem', 'ejob_for' => 'admin', "job" => "خادم", 'job_for' => 'مدیر کاروان', 'data' => []],
					'khadem_missionary'  => ['ejob' => 'khadem', 'ejob_for' => 'missionary', "job" => "خادم", 'job_for' => 'مبلغ', 'data' => []],
					'khadem_servant'     => ['ejob' => 'khadem', 'ejob_for' => 'servant', "job" => "خادم", 'job_for' => 'نگهبان', 'data' => []],
					'khadem_adminoffice' => ['ejob' => 'khadem', 'ejob_for' => 'adminoffice', "job" => "خادم", 'job_for' => 'روحانی کاروان', 'data' => []],
					'khadem_nazer'       => ['ejob' => 'khadem', 'ejob_for' => 'nazer', "job" => "خادم", 'job_for' => 'ناظر', 'data' => []],
					'khadem_maddah'      => ['ejob' => 'khadem', 'ejob_for' => 'maddah', "job" => "خادم", 'job_for' => 'مداح', 'data' => []],
					'khadem_clergy'      => ['ejob' => 'khadem', 'ejob_for' => 'clergy', "job" => "خادم", 'job_for' => 'مسئول زائرسرا', 'data' => []],
					'khadem_khadem2'     => ['ejob' => 'khadem', 'ejob_for' => 'khadem2', "job" => "خادم", 'job_for' => 'خادم ۲', 'data' => []],
				],
			],

			'khadem2' =>
			[
				'title' => 'خادم ۲',
				'list' =>
				[
					'khadem2_admin'       => ['ejob' => 'khadem2', 'ejob_for' => 'admin', "job" => "خادم ۲", 'job_for' => 'مدیر کاروان', 'data' => []],
					'khadem2_missionary'  => ['ejob' => 'khadem2', 'ejob_for' => 'missionary', "job" => "خادم ۲", 'job_for' => 'مبلغ', 'data' => []],
					'khadem2_servant'     => ['ejob' => 'khadem2', 'ejob_for' => 'servant', "job" => "خادم ۲", 'job_for' => 'نگهبان', 'data' => []],
					'khadem2_adminoffice' => ['ejob' => 'khadem2', 'ejob_for' => 'adminoffice', "job" => "خادم ۲", 'job_for' => 'روحانی کاروان', 'data' => []],
					'khadem2_nazer'       => ['ejob' => 'khadem2', 'ejob_for' => 'nazer', "job" => "خادم ۲", 'job_for' => 'ناظر', 'data' => []],
					'khadem2_maddah'      => ['ejob' => 'khadem2', 'ejob_for' => 'maddah', "job" => "خادم ۲", 'job_for' => 'مداح', 'data' => []],
					'khadem2_khadem'      => ['ejob' => 'khadem2', 'ejob_for' => 'khadem', "job" => "خادم ۲", 'job_for' => 'خادم', 'data' => []],
					'khadem2_clergy'      => ['ejob' => 'khadem2', 'ejob_for' => 'clergy', "job" => "خادم ۲", 'job_for' => 'مسئول زائرسرا', 'data' => []],
				],
			],


		];

		$load_assessment = \lib\db\assessment::get(['agent_assessment.send_id' => $send_id]);


		$send_detail = \dash\data::dataRow();
		foreach ($load_assessment as $key => $value)
		{

			$myKey = $value['job']. '_'. $value['job_for'];
			if(isset($sort[$value['job']]['list'][$myKey]))
			{
				$sort[$value['job']]['list'][$myKey]['data'] = $value;
			}
		}

		foreach ($sort as $key => $value)
		{
			foreach ($value['list'] as $k => $v)
			{
				if(empty($v['data']))
				{
					if(isset($send_detail[$v['ejob']. '_id']) && $send_detail[$v['ejob']. '_id'])
					{
						if(isset($send_detail[$v['ejob_for']. '_id']) && $send_detail[$v['ejob_for']. '_id'])
						{
							// nothing
						}
						else
						{
							unset($sort[$key]['list'][$k]);
						}
					}
					else
					{
						unset($sort[$key]);
					}
				}
			}
		}


		\dash\data::assessmentList($sort);

	}
}
?>