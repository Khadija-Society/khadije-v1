<?php
namespace content_agent\send\assessment;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantProfileView');
		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('magic');

		$assessment_item = \lib\app\assessment::get_item_by_send(\dash\request::get('id'));
		\dash\data::assessmentIem($assessment_item);

		$id = \dash\coding::decode(\dash\request::get('id'));

		if($id)
		{
			$saved = \lib\db\assessmentdetail::get(['agent_send_id' => $id]);
			if(is_array($saved))
			{
				$saved = array_combine(array_column($saved, 'assessmentitem_id'), $saved);
				\dash\data::savedScore($saved);
			}
		}

	}
}
?>