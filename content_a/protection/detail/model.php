<?php
namespace content_a\protection\detail;


class model
{

	public static function post()
	{

		if(\dash\request::post('changestatus') === 'changestatus')
		{
			$status = \dash\request::post('status');

			$post =
			[
				'occation_id'               => \dash\data::occasionID(),
				'protectionagetnoccasionid' => \dash\request::get('id'),
			];

			if($status === 'request')
			{
				$occasion_id = \dash\data::occasionID();

				$list = \lib\app\protectagentuser::occasion_list($occasion_id);
				if(!is_array($list))
				{
					$list = [];
				}
				if(!count($list))
				{
					\dash\notif::error(T_("Please add your protection person first"));
					return false;
				}

				$post['status'] = $status;
			}
			else
			{
				$post['status'] = 'draft';
			}

			$reault = \lib\app\protectionagentoccasion::edit_status($post);

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
			return;
		}
	}
}
?>
