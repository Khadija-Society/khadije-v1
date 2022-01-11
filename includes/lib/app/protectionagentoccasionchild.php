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

		if($capacity)
		{
			// check max limit
			$sum_capacity = \lib\db\protectionagentoccasionchild::get_sum_capacity(\dash\coding::decode($occasion_id), \dash\coding::decode(a($load_protection_agent_occasion, 'protection_agent_id')));
			$sum_capacity = floatval($sum_capacity);

			$new_capacity = $sum_capacity + $capacity;

			$total_capacity = \lib\db\protectionagentoccasion::get_allow(\dash\coding::decode(a($load_protection_agent_occasion, 'protection_agent_id')), \dash\coding::decode($occasion_id));

			if(isset($total_capacity['capacity']))
			{
				$total_capacity = floatval($total_capacity['capacity']);
			}
			else
			{
				$total_capacity = 0;
			}


			if($total_capacity && $new_capacity > $total_capacity)
			{
				\dash\notif::error(T_("Capacity is larger than total allowed capacity in this occaseion"), 'capacity');
				return false;
			}

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
			if(isset($check_duplicate['status']) && $check_duplicate['status'] === 'deleted')
			{
				$update =
				[
					'capacity'     => $capacity,
					'displayname'  => $displayname,
					'status'       => 'enable',
					'datemodified' => date("Y-m-d H:i:s")
				];

				\lib\db\protectionagentoccasionchild::update($update, $check_duplicate['id']);
			}
			else
			{
				\dash\notif::error(T_("This mobile already added"));
				return false;
			}
		}
		else
		{

			unset($check['limit']);

			$check['datecreated'] = date("Y-m-d H:i:s");
			$check['capacity']    = $capacity;
			$check['displayname'] = $displayname;
			$check['status']      = 'enable';

			$insert_id = \lib\db\protectionagentoccasionchild::insert($check);

			if(!$insert_id)
			{
				\dash\notif::error(T_("Can not add your data"));
				return false;
			}

		}

		\dash\notif::ok(T_("Access created"));
		return true;


	}


	public static function edit($_args, $_id)
	{

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

		if($capacity)
		{
			$load = \lib\db\protectionagentoccasionchild::get(['id' => $_id, 'limit' => 1]);
			if(!a($load, 'protection_agent_id') || !a($load, 'protection_occasion_id'))
			{
				\dash\notif::error(T_("Invalid id"));
				return false;
			}
			// check max limit
			$sum_capacity = \lib\db\protectionagentoccasionchild::get_sum_capacity(a($load, 'protection_occasion_id'), a($load, 'protection_agent_id'));
			$sum_capacity = floatval($sum_capacity);

			$new_capacity = $sum_capacity + $capacity;

			$total_capacity = \lib\db\protectionagentoccasion::get_allow(a($load, 'protection_agent_id'), a($load, 'protection_occasion_id'));

			if(isset($total_capacity['capacity']))
			{
				$total_capacity = floatval($total_capacity['capacity']);
			}
			else
			{
				$total_capacity = 0;
			}


			if($total_capacity && $new_capacity > $total_capacity)
			{
				\dash\notif::error(T_("Capacity is larger than total allowed capacity in this occaseion"), 'capacity');
				return false;
			}

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

		$update =
		[
			'user_id'      => $user_id,
			'displayname'  => $displayname,
			'capacity'     => $capacity,
			'datemodified' => date("Y-m-d H:i:s"),
		];

		\lib\db\protectionagentoccasionchild::update($update, $_id);

		\dash\notif::ok(T_("Data saved"));
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
			'protection_agent_occasion_child.status'                 => 'enable',
		];

		$detail =
		[
			'public_show_field' => 'protection_agent_occasion_child.*, users.mobile, (SELECT COUNT(*) FROM protection_user_agent_occasion WHERE protection_user_agent_occasion.creator = protection_agent_occasion_child.id) AS `total_signuped`',
			'master_join'       => 'INNER JOIN users ON users.id = protection_agent_occasion_child.user_id'
		];

		$get = \lib\db\protectionagentoccasionchild::get($check, $detail);


		return $get;




	}



	public static function get_by_id($_id)
	{
		if(!is_numeric($_id))
		{
			return false;
		}


		$check =
		[
			'protection_agent_occasion_child.id' => $_id,
			'limit' => 1,
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

		$check_added = \lib\db\protectionagentuser::get(['creator' => $get['id'], 'limit' => 1]);
		if(isset($check_added['id']))
		{
			\lib\db\protectionagentoccasionchild::update(['status' => 'deleted', 'datemodified' => date("Y-m-d H:i:s")], $get['id']);
		}
		else
		{
			// check any added and set status on deleted
			// or remove record
			\lib\db\protectionagentoccasionchild::remove($get['id']);
		}

		\dash\notif::ok(T_("Access removed"));


		return true;

	}
}
?>
