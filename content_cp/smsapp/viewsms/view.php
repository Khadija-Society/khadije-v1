<?php
namespace content_cp\smsapp\viewsms;


class view
{
	public static function config()
	{
		\dash\data::page_pictogram('server');
		\dash\data::page_title(T_("View sms detail"));
		\dash\data::page_desc(T_("You cat set some group for sms"));
		\dash\data::badge_link(\dash\url::this());
		\dash\data::badge_text(T_('Back to dashboard'));


		$smsgroup = \lib\db\smsgroup::get(['1.1' => ["=", "1.1"]]);

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
	}
}
?>
