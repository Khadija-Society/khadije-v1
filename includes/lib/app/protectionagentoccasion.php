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

	public static function admin_get($_id)
	{


		$id = \dash\coding::decode($_id);

		if(!$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}

		$get_args =
		[
			'id'                  => $id,
			'limit'               => 1,
		];

		$get = \lib\db\protectionagentoccasion::get($get_args);

		if(!$get)
		{
			return false;
		}


		$result = self::ready($get);
		if(isset($result['protection_agent_id']) && $result['protection_agent_id'])
		{
			$get_agent = \lib\app\protectagent::get($result['protection_agent_id']);
			$result['agent_detail'] = $get_agent;
		}

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




	public static function edit_gallery($_args, $_type)
	{
		$occation_id               = isset($_args['occation_id']) ? $_args['occation_id'] : null;
		$protectionagetnoccasionid = isset($_args['protectionagetnoccasionid']) ? $_args['protectionagetnoccasionid'] : null;
		$file_new                  = isset($_args['file_new']) ? $_args['file_new'] : null;
		$file_remove_key           = isset($_args['file_remove_key']) ? $_args['file_remove_key'] : null;

		if($_type === 'add')
		{
			if(!$file_new)
			{
				\dash\notif::error(T_("Please upload a file"));
				return false;
			}
		}

		$id = \dash\coding::decode($protectionagetnoccasionid);
		$occation_id = \dash\coding::decode($occation_id);

		if(!$occation_id || !$protectionagetnoccasionid  || !$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			return false;
		}

		$get_args =
		[
			'id'                     => $id,
			'protection_occasion_id' => $occation_id,
			'protection_agent_id'    => $protection_agent_id,
			'limit'                  => 1,
		];

		$get = \lib\db\protectionagentoccasion::get($get_args);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid detail"));
			return false;
		}

		$old_gallery = $get['gallery'];
		$old_gallery = json_decode($old_gallery, true);
		if(!is_array($old_gallery))
		{
			$old_gallery = [];
		}

		if($_type === 'add')
		{
			if(in_array($file_new, $old_gallery))
			{
				\dash\notif::error(T_("Duplicate file"));
				return false;
			}

			$old_gallery[] = $file_new;
		}
		else
		{
			if(!array_key_exists($file_remove_key, $old_gallery))
			{
				\dash\notif::error(T_("Can not find this file in your gallery"));
				return false;
			}

			unset($old_gallery[$file_remove_key]);
		}

		$old_gallery = json_encode($old_gallery, JSON_UNESCAPED_UNICODE);

		$update = ['gallery' => $old_gallery];

		\lib\db\protectionagentoccasion::update($update, $id);

		\dash\notif::ok("Gallery updated");

		return true;
	}


	public static function edit_report($_args)
	{
		$occation_id               = isset($_args['occation_id']) ? $_args['occation_id'] : null;
		$protectionagetnoccasionid = isset($_args['protectionagetnoccasionid']) ? $_args['protectionagetnoccasionid'] : null;
		$report                    = isset($_args['report']) ? $_args['report'] : null;

		if(!$report)
		{
			\dash\notif::error(T_("Please fill the report text"));
			return false;
		}

		$id = \dash\coding::decode($protectionagetnoccasionid);
		$occation_id = \dash\coding::decode($occation_id);

		if(!$occation_id || !$protectionagetnoccasionid  || !$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			return false;
		}

		$get_args =
		[
			'id'                     => $id,
			'protection_occasion_id' => $occation_id,
			'protection_agent_id'    => $protection_agent_id,
			'limit'                  => 1,
		];

		$get = \lib\db\protectionagentoccasion::get($get_args);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid detail"));
			return false;
		}

		$update = ['report' => $report];

		\lib\db\protectionagentoccasion::update($update, $id);

		\dash\notif::ok("Your report was saved");

		return true;
	}

	public static function edit_status($_args)
	{
		$occation_id               = isset($_args['occation_id']) ? $_args['occation_id'] : null;
		$protectionagetnoccasionid = isset($_args['protectionagetnoccasionid']) ? $_args['protectionagetnoccasionid'] : null;
		$status                    = isset($_args['status']) ? $_args['status'] : null;

		$id = \dash\coding::decode($protectionagetnoccasionid);
		$occation_id = \dash\coding::decode($occation_id);

		if(!$occation_id || !$protectionagetnoccasionid || !$status || !$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


		$protection_agent_id = \lib\app\protectagent::get_current_id();
		if(!$protection_agent_id)
		{
			return false;
		}

		$get_args =
		[
			'id'                     => $id,
			'protection_occasion_id' => $occation_id,
			'protection_agent_id'    => $protection_agent_id,
			'limit'                  => 1,
		];

		$get = \lib\db\protectionagentoccasion::get($get_args);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid detail"));
			return false;
		}

		$update = ['status' => $status];

		\lib\db\protectionagentoccasion::update($update, $id);

		\dash\notif::ok("Your request was queued");

		return true;
	}

	public static function admin_edit_status($_args)
	{
		$occation_id               = isset($_args['occation_id']) ? $_args['occation_id'] : null;
		$protectionagetnoccasionid = isset($_args['protectionagetnoccasionid']) ? $_args['protectionagetnoccasionid'] : null;
		$status                    = isset($_args['status']) ? $_args['status'] : null;

		$id = \dash\coding::decode($protectionagetnoccasionid);
		$occation_id = \dash\coding::decode($occation_id);

		if(!$occation_id || !$protectionagetnoccasionid || !$status || !$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}



		$get_args =
		[
			'id'                     => $id,
			'protection_occasion_id' => $occation_id,

			'limit'                  => 1,
		];

		$get = \lib\db\protectionagentoccasion::get($get_args);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid detail"));
			return false;
		}

		$update = ['status' => $status];

		\lib\db\protectionagentoccasion::update($update, $id);

		\dash\notif::ok("Data saved");

		return true;
	}



	public static function check()
	{
		$bankshaba = \dash\app::request('bankshaba');
		if($bankshaba && mb_strlen($bankshaba) > 150)
		{
			$bankshaba = substr($bankshaba, 0, 150);
		}

		$bankhesab = \dash\app::request('bankhesab');
		if($bankhesab && mb_strlen($bankhesab) > 150)
		{
			$bankhesab = substr($bankhesab, 0, 150);
		}


		$bankcart = \dash\app::request('bankcart');
		if($bankcart && mb_strlen($bankcart) > 150)
		{
			$bankcart = substr($bankcart, 0, 150);
		}


		$bankname = \dash\app::request('bankname');
		if($bankname && mb_strlen($bankname) > 150)
		{
			$bankname = substr($bankname, 0, 150);
		}

		$bankownername = \dash\app::request('bankownername');
		if($bankownername && mb_strlen($bankownername) > 150)
		{
			$bankownername = substr($bankownername, 0, 150);
		}

		$report = \dash\app::request('report');

		$args = [];


		$args['bankshaba']     = $bankshaba;
		$args['bankhesab']     = $bankhesab;
		$args['bankcart']      = $bankcart;
		$args['bankname']      = $bankname;
		$args['bankownername'] = $bankownername;
		$args['bankownername'] = $bankownername;
		$args['report']        = $report;

		return $args;
	}


	public static function edit($_args)
	{
		$occation_id               = isset($_args['occation_id']) ? $_args['occation_id'] : null;
		$protectionagetnoccasionid = isset($_args['protectionagetnoccasionid']) ? $_args['protectionagetnoccasionid'] : null;
		$is_admin                  = (isset($_args['is_admin']) && $_args['is_admin']) ? true : false;


		\dash\app::variable($_args);

		$id = \dash\coding::decode($protectionagetnoccasionid);
		$occation_id = \dash\coding::decode($occation_id);

		if(!$occation_id || !$protectionagetnoccasionid  || !$id)
		{
			\dash\notif::error(T_("Invalid id"));
			return false;
		}


		if($is_admin)
		{
			$get_args =
			[
				'id'                     => $id,
				'protection_occasion_id' => $occation_id,
				'limit'                  => 1,
			];
		}
		else
		{

			$protection_agent_id = \lib\app\protectagent::get_current_id();
			if(!$protection_agent_id)
			{
				return false;
			}

			$get_args =
			[
				'id'                     => $id,
				'protection_occasion_id' => $occation_id,
				'protection_agent_id'    => $protection_agent_id,
				'limit'                  => 1,
			];
		}


		$get = \lib\db\protectionagentoccasion::get($get_args);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid detail"));
			return false;
		}

		$args = self::check();

		if(!$args || !\dash\engine\process::status())
		{
			return false;
		}

		if(!\dash\app::isset_request('bankshaba'))	unset($args['bankshaba']);
		if(!\dash\app::isset_request('bankhesab'))	unset($args['bankhesab']);
		if(!\dash\app::isset_request('bankcart'))	unset($args['bankcart']);
		if(!\dash\app::isset_request('bankname'))	unset($args['bankname']);
		if(!\dash\app::isset_request('bankownername'))	unset($args['bankownername']);
		if(!\dash\app::isset_request('report'))	unset($args['report']);

		if(!empty($args))
		{
			\lib\db\protectionagentoccasion::update($args, $id);

			\dash\notif::ok("Data saved");

			return true;
		}
		else
		{
			\dash\notif::ok("No change in your data");

			return true;
		}

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




	public static $sort_field =
	[
		'id',
	];


	/**
	 * Gets the protectagentuser.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The protectagentuser.
	 */
	public static function list($_string = null, $_args = [])
	{
		// if(!\dash\user::id())
		// {
		// 	return false;
		// }

		$default_meta =
		[
			'sort'  => null,
			'order' => null,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_meta, $_args);

		if($_args['sort'] && !in_array($_args['sort'], self::$sort_field))
		{
			$_args['sort'] = null;
		}

		$result            = \lib\db\protectionagentoccasion::search($_string, $_args);
		$temp              = [];

		foreach ($result as $key => $value)
		{
			$check = self::ready($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		return $temp;
	}



}
?>