<?php
namespace lib\app;

/**
 * Class for protectagent.
 */
class protectionagentoccasionchild
{

	public static function add($_args)
	{

		$occasion_id = isset($_args['occasion_id']) ? $_args['occasion_id'] : null;
		if(!$occasion_id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$load = \lib\app\occasion::get($occasion_id);
		if(!isset($load['id']))
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$protectionagetnoccasionid = isset($_args['protectionagetnoccasionid']) ? $_args['protectionagetnoccasionid'] : null;
		if(!$protectionagetnoccasionid)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$load_protection_agent_occasion = \lib\app\protectionagentoccasion::admin_get($protectionagetnoccasionid);
		if(!$load_protection_agent_occasion)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$capacity = isset($_args['capacity']) ? $_args['capacity'] : null;
		if($capacity && !is_numeric($capacity))
		{
			\dash\notif::error(T_("capacity must be a number"));
			return false;
		}

		$capacity = intval($capacity);
		if($capacity > 100000)
		{
			\dash\notif::error(T_("capacity is out of range"));
			return false;
		}

		$mobile = isset($_args['mobile']) ? $_args['mobile'] : null;
		$mobile = \dash\utility\filter::mobile($mobile);
		if(!$mobile)
		{
			\dash\notif::error(T_("Mobile is required"));
			return false;
		}

		$user_id = \dash\db\users::signup(['mobile' => $mobile]);


		$displayname = isset($_args['displayname']) ? $_args['displayname'] : null;
		if(mb_strlen($displayname) > 100)
		{
			$displayname = substr($displayname, 0, 99);
		}


		$check =
		[
			'protection_occasion_id' => \dash\coding::decode($occasion_id),
			'protection_agent_id'    => \dash\coding::decode(a($load_protection_agent_occasion, 'protection_agent_id')),
			'user_id'                => $user_id,
			'limit'                  => 1,
		];

		$check_duplicate = \lib\db\protectionagentoccasionchild::get($check);
		if(isset($check_duplicate['id']))
		{
			\dash\notif::error(T_("This mobile already added"));
			return false;
		}

		unset($check['limit']);

		$check['datecreated'] = date("Y-m-d H:i:s");
		$check['capacity']    = $capacity;
		$check['displayname']    = $displayname;

		$insert_id = \lib\db\protectionagentoccasionchild::insert($check);

		if(!$insert_id)
		{
			\dash\notif::error(T_("Can not add yoru data"));
			return false;
		}

		\dash\notif::ok(T_("Access created"));
		return true;


	}


	public static function get($_occasion_id, $_protection_agent_id)
	{

		$load = \lib\app\occasion::get($_occasion_id);
		if(!isset($load['id']))
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$load_protection_agent_occasion = \lib\app\protectionagentoccasion::admin_get($_protection_agent_id);
		if(!$load_protection_agent_occasion)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


		$check =
		[
			'protection_occasion_id' => \dash\coding::decode($_occasion_id),
			'protection_agent_id'    => \dash\coding::decode(a($load_protection_agent_occasion, 'protection_agent_id')),
		];

		$get = \lib\db\protectionagentoccasionchild::get($check, ['public_show_field' => 'protection_agent_occasion_child.*, users.mobile', 'master_join' => 'INNER JOIN users ON users.id = protection_agent_occasion_child.user_id']);


		return $get;




	}


	public static function remove($_occasion_id, $_protection_agent_id, $_id)
	{

		$load = \lib\app\occasion::get($_occasion_id);
		if(!isset($load['id']))
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$load_protection_agent_occasion = \lib\app\protectionagentoccasion::admin_get($_protection_agent_id);
		if(!$load_protection_agent_occasion)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


		$check =
		[
			'protection_occasion_id' => \dash\coding::decode($_occasion_id),
			'protection_agent_id'    => \dash\coding::decode(a($load_protection_agent_occasion, 'protection_agent_id')),
			'id'                     => $_id,
			'limit'                  => 1,
		];

		$get = \lib\db\protectionagentoccasionchild::get($check);

		if(!isset($get['id']))
		{
			\dash\notif::error(T_("Id not found"));
			return false;
		}

		\lib\db\protectionagentoccasionchild::remove($get['id']);

		\dash\notif::ok(T_("Access removed"));


		return true;

	}
}
?>
