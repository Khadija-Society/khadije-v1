<?php
namespace content_cp\nationalcode\edit;


class model
{
	public static function post()
	{
		\dash\permission::access('cpNationalCodeEdit');

		$update            = [];
		$update['qom']     = \dash\request::post('qom');
		$update['mashhad'] = \dash\request::post('mashhad');
		$update['karbala'] = \dash\request::post('karbala');

		if($update['qom'] && !is_numeric($update['qom']) || intval($update['qom']) > 999)
		{
			\dash\notif::error(T_("Invalid qom number"), 'qom');
			return false;
		}
		if(!$update['qom'])
		{
			$update['qom'] = null;
		}


		if($update['mashhad'] && !is_numeric($update['mashhad']) || intval($update['mashhad']) > 999)
		{
			\dash\notif::error(T_("Invalid mashhad number"), 'mashhad');
			return false;
		}
		if(!$update['mashhad'])
		{
			$update['mashhad'] = null;
		}

		if($update['karbala'] && !is_numeric($update['karbala']) || intval($update['karbala']) > 999)
		{
			\dash\notif::error(T_("Invalid karbala number"), 'karbala');
			return false;
		}
		if(!$update['karbala'])
		{
			$update['karbala'] = null;
		}

		if(\dash\request::get('id') && is_numeric(\dash\request::get('id')))
		{
			\lib\db\nationalcodes::update($update, \dash\request::get('id'));
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("Your change was saved"));
			}
		}
		else
		{
			\dash\notif::error(T_("Id not found"));
		}


	}
}
?>
