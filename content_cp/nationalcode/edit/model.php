<?php
namespace content_cp\nationalcode\edit;


class model extends \content_cp\main2\model
{
	public function post_nationalcode()
	{
		$update            = [];
		$update['qom']     = \dash\request::post('qom');
		$update['mashhad'] = \dash\request::post('mashhad');
		$update['karbala'] = \dash\request::post('karbala');

		if($update['qom'] && !is_numeric($update['qom']) || intval($update['qom']) > 999)
		{
			\lib\notif::error(T_("Invalid qom number"), 'qom');
			return false;
		}
		if(!$update['qom'])
		{
			$update['qom'] = null;
		}


		if($update['mashhad'] && !is_numeric($update['mashhad']) || intval($update['mashhad']) > 999)
		{
			\lib\notif::error(T_("Invalid mashhad number"), 'mashhad');
			return false;
		}
		if(!$update['mashhad'])
		{
			$update['mashhad'] = null;
		}

		if($update['karbala'] && !is_numeric($update['karbala']) || intval($update['karbala']) > 999)
		{
			\lib\notif::error(T_("Invalid karbala number"), 'karbala');
			return false;
		}
		if(!$update['karbala'])
		{
			$update['karbala'] = null;
		}

		if(\dash\request::get('id') && is_numeric(\dash\request::get('id')))
		{
			\lib\db\nationalcodes::update($update, \dash\request::get('id'));
			if(\lib\engine\process::status())
			{
				\lib\notif::ok(T_("Your change was saved"));
			}
		}
		else
		{
			\lib\notif::error(T_("Id not found"));
		}


	}
}
?>
