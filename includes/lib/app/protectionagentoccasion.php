<?php
namespace lib\app;

/**
 * Class for protectagent.
 */
class protectionagentoccasion
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
			return false;
		}

		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			return false;
		}

		if(isset($load['status']) && in_array($load['status'], ['registring', 'distribution']))
		{
			// ok
		}
		else
		{
			\dash\notif::error(T_("This occasion is not enable"));
			return false;
		}

		$check_duplicate =
		[
			'protection_occasion_id' => \dash\coding::decode($occasion_id),
			'protection_agent_id'    => $protection_agent_id,
			'limit' => 1
		];

		$check = \lib\db\protectionagentoccasion::get($check_duplicate);
		if(isset($check['id']))
		{
			\dash\notif::error(T_("You already registered to this occasion"));
			return false;
		}


		$insert =
		[
			'protection_occasion_id' => \dash\coding::decode($occasion_id),
			'protection_agent_id'    => $protection_agent_id,
			'status'                 => 'draft',
			'datecreated'            => date("Y-m-d H:i:s"),
		];

		$id = \lib\db\protectionagentoccasion::insert($insert);
		if(!$id)
		{
			\dash\notif::error(T_("No way to insert data"));
			return false;
		}

		\dash\notif::ok(T_("Your request was saved"));
		return ['id' => \dash\coding::encode($id)];

	}


	public static function get($_id)
	{
		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			return false;
		}

		$id = \dash\coding::decode($_id);

		if(!$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$get_args =
		[
			'id'                  => $id,
			'protection_agent_id' => $protection_agent_id,
			'limit'               => 1,
		];

		$get = \lib\db\protectionagentoccasion::get($get_args);

		if(!$get)
		{
			return false;
		}

		$result = self::ready($get);

		return $result;
	}

	public static function old_registered_occasion()
	{
		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			return false;
		}

		$get = \lib\db\protectionagentoccasion::old_registered_occasion($protection_agent_id);

		if(!$get)
		{
			return false;
		}

		$result = array_map(['self', 'ready'], $get);

		return $result;
	}


	/**
	 * ready data of protectagentuser to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready($_data)
	{
		$result = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
				case 'protection_occasion_id':
				case 'protection_agent_id':
					$result[$key] = \dash\coding::encode($value);
					break;


				default:
					$result[$key] = $value;
					break;
			}
		}

		return $result;
	}
}
?>