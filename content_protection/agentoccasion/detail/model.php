<?php
namespace content_protection\agentoccasion\detail;


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
