<?php
namespace lib\app;

/**
 * Class for sms.
 */
class sms
{
	public static function get_tg_text($_chat_id, $_smsid)
	{
		$load = \lib\db\sms::get(['s_sms.id' => $_smsid, 'limit' => 1]);
		if($load)
		{
			return $load;
		}

	}

	public static function group_list()
	{
		$smsgroup = \lib\db\smsgroup::get(['analyze' => 1]);
		return $smsgroup;
	}


	public static function get_group($_group_id)
	{
		return \lib\db\smsgroup::get(['id' => $_group_id, 'limit' => 1]);
	}


	public static function answer_list($_group_id)
	{
		// $_group_id = \dash\coding::decode($_group_id);
		if($_group_id && is_numeric($_group_id))
		{
			$answers = \lib\db\smsgroupfilter::get(['type' => 'answer', 'group_id' => $_group_id]);
			return $answers;
		}
	}


	public static function set_group($_smsid, $_group_id)
	{
		if($_smsid && $_group_id)
		{
			\lib\db\sms::update(['group_id' => $_group_id], $_smsid);
		}
	}

	public static function get_answer($_answer_id)
	{
		$load = \lib\db\smsgroupfilter::get(['id' => $_answer_id, 'limit' => 1]);
		return $load;
	}


	public static function set_answer($_smsid, $_answer_id)
	{
		$load = self::get_answer($_answer_id);

		if(isset($load['text']))
		{
			$post               = [];
			$post['answertext'] = $load['text'];
			$post['sendstatus'] = 'awaiting';
			$result             = \lib\app\sms::edit($post, \dash\coding::encode($_smsid));
			\dash\notif::clean();
		}

	}

	// not remvoe html tag and single or dbl qute from this field
	// because get from editor
	public static $raw_field =
	[
		// no field
	];

	public static $sort_field =
	[
		'fromnumber',
		'togateway',
		'fromgateway',
		'tonumber',
		'date',
		'datecreated',
		'reseivestatus',
		'sendstatus',
		'amount',
		'group_id',
		'recommend_id',

	];

	public static function chart()
	{
		$get = \lib\db\sms::get_chart();
		if(!is_array($get))
		{
			$get = [];
		}

		foreach ($get as $key => $value)
		{

		}
	}

	/**
	 * add new sms
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args = [])
	{
		$raw_field =

		\dash\app::variable($_args, ['raw_field' => self::$raw_field]);

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("User not found"), 'user');
			return false;
		}

		// check args
		$args = self::check();

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		$return = [];


		$args = array_filter($args);

		$sms_id = \lib\db\sms::insert($args);

		if(!$sms_id)
		{
			\dash\notif::error(T_("No way to insert sms"), 'db');
			return false;
		}

		$return['id'] = \dash\coding::encode($sms_id);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Sms successfuly added"));
		}

		return $return;
	}




	/**
	 * Gets the sms.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The sms.
	 */
	public static function list($_string = null, $_args = [])
	{
		if(!\dash\user::id())
		{
			return false;
		}

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


		$result            = \lib\db\sms::search($_string, $_args);
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


	/**
	 * edit a sms
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function edit($_args, $_id)
	{
		\dash\app::variable($_args, ['raw_field' => self::$raw_field]);

		$id = \dash\coding::decode($_id);

		if(!$id)
		{
			return false;
		}

		$args = self::check($id);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		if(!\dash\app::isset_request('fromgateway')) unset($args['fromgateway']);
		if(!\dash\app::isset_request('tonumber')) unset($args['tonumber']);
		if(!\dash\app::isset_request('reseivestatus')) unset($args['reseivestatus']);
		if(!\dash\app::isset_request('sendstatus')) unset($args['sendstatus']);
		if(!\dash\app::isset_request('amount')) unset($args['amount']);
		if(!\dash\app::isset_request('answertext')) unset($args['answertext']);
		if(!\dash\app::isset_request('group_id')) unset($args['group_id']);

		if(!empty($args))
		{
			$update = \lib\db\sms::update($args, $id);
			\dash\notif::ok(T_("Sms successfully updated"));

		}
	}


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("Sms group id not set"));
			return false;
		}


		$get = \lib\db\sms::get(['s_sms.id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid sms id"));
			return false;
		}

		$result = self::ready($get);

		return $result;
	}


	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_id = null)
	{

		// $fromnumber = \dash\app::request('fromnumber');
		// $togateway = \dash\app::request('togateway');
		// $text = \dash\app::request('text');
		// $user_id = \dash\app::request('user_id');
		// $date = \dash\app::request('date');
		// $datecreated = \dash\app::request('datecreated');
		// $datemodified = \dash\app::request('datemodified');
		// $uniquecode = \dash\app::request('uniquecode');
		// $recommend_id = \dash\app::request('recommend_id');

		$fromgateway = \dash\app::request('fromgateway');
		$tonumber    = \dash\app::request('tonumber');

		$reseivestatus = \dash\app::request('reseivestatus');
		if($reseivestatus && !in_array($reseivestatus, ['block', 'awaiting', 'analyze', 'answerready']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}

		$sendstatus = \dash\app::request('sendstatus');
		if($reseivestatus && !in_array($reseivestatus, ['awaiting', 'sendtodevice', 'send', 'deliver']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}

		$amount = \dash\app::request('amount');
		$amount = \dash\utility\convert::to_en_number($amount);
		if($amount && !is_numeric($amount))
		{
			\dash\notif::error(T_("Please set amount as a number"), 'amount');
			return false;
		}


		if($amount && intval($amount) > 99999999)
		{
			\dash\notif::error(T_("Amount is out of range"));
			return false;
		}


		$answertext = \dash\app::request('answertext');

		$group_id = \dash\app::request('group_id');
		// $group_id = \dash\coding::decode($group_id);
		if($group_id)
		{
			$get = \lib\db\smsgroup::get(['id' => $group_id, 'limit' => 1]);
			if(!isset($get['id']))
			{
				\dash\notif::error(T_("Invalid id"));
				return false;
			}
		}

		$args                  = [];
		$args['fromgateway']   = $fromgateway;
		$args['tonumber']      = $tonumber;
		$args['reseivestatus'] = $reseivestatus;
		$args['sendstatus']    = $sendstatus;
		$args['amount']        = $amount;
		$args['answertext']    = $answertext;
		$args['group_id']      = $group_id;


		return $args;
	}


	/**
	 * ready data of sms to load in api
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
				case 'creator':

					$result[$key] = \dash\coding::encode($value);
					break;

				case 'answer':
					$result[$key] = json_decode($value, true);
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