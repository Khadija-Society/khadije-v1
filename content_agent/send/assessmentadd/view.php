<?php
namespace content_agent\send\assessmentadd;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantProfileView');
		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('magic');

		$assessment_item = \lib\app\assessment::get_item_by_send(\dash\request::get('id'));
		\dash\data::assessmentIem($assessment_item);


		$job = \dash\request::get('job');
		$forjob = \dash\request::get('forjob');

		$dataRow = \dash\data::dataRow();

		$inputHidden = [];

		$inputHidden['job']     = $job;
		$inputHidden['job_for'] = $forjob;

		if($job && $forjob)
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

			if(isset($dataRow[$forjob .'_displayname']))
			{
				$msgTxt .= " از ". self::b($dataRow[$forjob .'_displayname']);
				$msgTxt .= self::position($forjob);
			}

			if(isset($dataRow[$forjob .'_id']))
			{
				$inputHidden['assessment_for'] = $dataRow[$forjob .'_id'];
			}

			\dash\data::msgTxt($msgTxt);
		}

		\dash\data::inputHidden($inputHidden);

		$id = \dash\coding::decode(\dash\request::get('assessment_id'));

		if($id)
		{
			$assessmenDetail = \lib\db\assessment::get(['agent_assessment.id' => $id, 'limit' => 1]);
			\dash\data::assessmenDetail($assessmenDetail);


			$saved = \lib\db\assessmentdetail::get(['agent_send_id' => $id]);
			if(is_array($saved))
			{
				$saved = array_combine(array_column($saved, 'assessmentitem_id'), $saved);
				\dash\data::savedScore($saved);
			}
		}

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

		];

		if(isset($jobList[$_job]))
		{
			return ' به عنوان ' . '<span class="fc-red txtB">'.$jobList[$_job]. '</span>';
		}
	}
}
?>