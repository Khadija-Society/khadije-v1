<?php
namespace content_a\servant\report;


class model
{
	public static function post()
	{
		if(\dash\request::post('remove') === 'remove')
		{
			$id = \dash\request::post('id');
			$id = \dash\coding::decode($id);
			if($id)
			{
				\lib\db\agentfile::remove($id);
				\dash\redirect::pwd();
			}
		}

		$file = \dash\app\file::upload_quick('image');
		if($file)
		{
			$insert =
			[
				'send_id' => \dash\coding::decode(\dash\request::get('id')),
				'file'    => $file,

				'creator' => \dash\user::id(),
			];

			$check = ['send_id' => \dash\coding::decode(\dash\request::get('id')), 'file'    => $file, 'limit' => 1];
			if(\lib\db\agentfile::get($check))
			{
				return;
			}
			$id = \lib\db\agentfile::insert($insert);
			if($id)
			{
				\dash\notif::ok("فایل ارسال شد");
				\dash\redirect::pwd();
			}
		}
		else
		{
			\dash\notif::warn('هیچ فایلی ارسال نشده است');
			return false;
		}
	}
}
?>