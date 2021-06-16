<?php
namespace content_smsapp\viewsms;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');
		\dash\data::page_title(T_("View sms detail"));
		\dash\data::page_desc(T_("You cat set some group for sms"));
		\dash\data::badge_link(\dash\url::here(). '/listsms' . \dash\data::platoonGet());
		\dash\data::badge_text(T_('Back sms list'));


		$smsgroup = \lib\db\smsgroup::get(['platoon' => \lib\app\platoon\tools::get_index_locked()]);

		\dash\data::groupList($smsgroup);

		$answers = \lib\db\smsgroupfilter::get(['type' => 'answer']);
		$dataAnswer = [];
		if(is_array($answers))
		{
			foreach ($answers as $key => $value)
			{
				if(!isset($dataAnswer[$value['group_id']]))
				{
					$dataAnswer[$value['group_id']] = [];
				}

				$dataAnswer[$value['group_id']][] = $value;
			}
		}

		\dash\data::dataAnswer($dataAnswer);

		if(\dash\data::dataRow_fromnumber())
		{
			$get_count = \lib\db\sms::get_count(['s_sms.platoon' => \lib\app\platoon\tools::get_index_locked(), 'fromnumber' => \dash\data::dataRow_fromnumber()]);
			\dash\data::countSmsFromThis($get_count);
		}
	}
}
?>
