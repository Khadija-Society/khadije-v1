<?php
namespace content_agent\send\assessmentadd;


class view
{
	public static function config()
	{

		\dash\data::page_title("ثبت ارزیابی");

		\dash\data::page_pictogram('plus');

		\dash\data::badge_link(\dash\url::this(). '/assessment?id='. \dash\request::get('id'). \dash\data::xCityAnd());
		\dash\data::badge_text(T_('Back'));


		$assessment_id = \dash\coding::decode(\dash\request::get('assessment_id'));

		if($assessment_id)
		{
			$assessmenDetail = \lib\db\assessment::get(['agent_assessment.id' => $assessment_id, 'limit' => 1]);
			\dash\data::assessmenDetail($assessmenDetail);


			$saved = \lib\db\assessmentdetail::get(['assessment_id' => $assessment_id]);
			if(is_array($saved))
			{
				$saved = array_combine(array_column($saved, 'assessmentitem_id'), $saved);
				\dash\data::savedScore($saved);
			}
		}

		$job = \dash\request::get('job');
		$xjob2 = $job;
		if(isset($assessmenDetail['job']))
		{
			$xjob2 = $assessmenDetail['job'];
		}

		$job_for = \dash\request::get('forjob');

		$xjob = $job_for;
		if(isset($assessmenDetail['job_for']))
		{
			$xjob = $assessmenDetail['job_for'];
		}


		$assessment_item = \lib\app\assessment::get_item_by_send(\dash\request::get('id'), $xjob, $xjob2);

		\dash\data::assessmentIem($assessment_item);



		$dataRow = \dash\data::dataRow();

		$inputHidden = [];

		if(\dash\data::assessmenDetail_job())
		{
			$job = \dash\data::assessmenDetail_job();
		}

		if(\dash\data::assessmenDetail_job_for())
		{
			$job_for = \dash\data::assessmenDetail_job_for();
		}

		$inputHidden['job']     = $job;
		$inputHidden['job_for'] = $job_for;

		if($job && $job_for)
		{
			$msgTxt = '';

			if(isset($dataRow[$job .'_id']))
			{
				$inputHidden['assessmentor'] = $dataRow[$job .'_id'];
			}

			if(isset($dataRow[$job .'_displayname']))
			{
				$msgTxt .= "ارزیابی ". self::b($dataRow[$job .'_displayname']);
				$msgTxt .= self::position($job);
			}

			if(isset($dataRow[$job_for .'_displayname']))
			{
				$msgTxt .= " از ". self::b($dataRow[$job_for .'_displayname']);
				$msgTxt .= self::position($job_for);
			}

			if(isset($dataRow[$job_for .'_id']))
			{
				$inputHidden['assessment_for'] = $dataRow[$job_for .'_id'];
			}

			\dash\data::msgTxt($msgTxt);
		}


		\dash\data::inputHidden($inputHidden);



	}


	private static function b($_text)
	{
		return ' <span class="fc-green txtB">'. $_text. '</span> ';
	}

	private static function position($_job)
	{
		$jobList =
		[
			'admin' => 'مدیر کاروان',
			'adminoffice' => 'مسئول زائرسرا',
			'servant' => 'نگهبان',
			'clergy' => 'روحانی',
			'missionary' => 'مبلغ',
			'khadem' => 'خادم',
			'khadem2' => 'خادم',
			'nazer' => 'ناظر',
			'maddah' => 'مداح',
			'rabet' => 'رابط',


		];

		if(isset($jobList[$_job]))
		{
			return ' به عنوان ' . '<span class="fc-red txtB">'.$jobList[$_job]. '</span>';
		}
	}
}
?>