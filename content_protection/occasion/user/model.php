<?php
namespace content_protection\occasion\user;


class model
{
	public static function post()
	{
		$occasion_id = \dash\request::get('id');
		$useragentid = \dash\request::post('useragentid');

		if(\dash\request::post('type') === 'reject')
		{
			\lib\app\protectagentuser::update_status($occasion_id, $useragentid, 'reject');
		}

		if(\dash\request::post('type') === 'accept')
		{
			\lib\app\protectagentuser::update_status($occasion_id, $useragentid, 'accept');
		}

		if(\dash\engine\process::status())
		{
			\dash\redirect::pwd();
		}


	}
}
?>