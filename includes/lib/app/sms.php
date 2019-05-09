<?php
namespace lib\app;

/**
 * Class for sms.
 */
class sms
{
	public static function dashboard_detail()
	{

		$result           = [];
		$result['status'] = \content_api\v6\smsapp\controller::status();

		$day              = [];
		$day['send']      = \lib\db\sms::get_count_sms('day', 'send');
		$day['receive']   = \lib\db\sms::get_count_sms('day', 'receive');

		$week             = [];
		$week['send']     = \lib\db\sms::get_count_sms('week', 'send');
		$week['receive']  = \lib\db\sms::get_count_sms('week', 'receive');

		$month            = [];
		$month['send']    = \lib\db\sms::get_count_sms('month', 'send');
		$month['receive'] = \lib\db\sms::get_count_sms('month', 'receive');

		$total            = [];
		$total['send']    = \lib\db\sms::get_count_sms('total', 'send');
		$total['receive'] = \lib\db\sms::get_count_sms('total', 'receive');


		$result['day']    = $day;
		$result['week']   = $week;
		$result['month']  = $month;
		$result['total']  = $total;
		return $result;
	}


	public static function setting_file($_set = [])
	{
		$get  = [];
		$addr = root.'includes/lib/app/smsapp.me.txt';
		$addr = \autoload::fix_os_path($addr);

		if(is_file($addr))
		{
			$get = \dash\file::read($addr);
			$get = json_decode($get, true);
		}
		else
		{
			$get = ['status' => true];
			\dash\file::write($addr, $get);
		}

		if(!is_array($get))
		{
			$get = [];
		}

		if($_set && is_array($_set))
		{
			$get = array_merge($get, $_set);
			$get = json_encode($get, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
			\dash\file::write($addr, $get);
		}

		return $get;
	}


	public static function status($_set = null)
	{
		$setting_file = self::setting_file();
		if($_set === false)
		{
			$status =
			[
				'status' => false,
			];
			self::setting_file($status);
			return true;
		}
		elseif($_set === true)
		{
			$status =
			[
				'status' => true,
			];
			self::setting_file($status);
			return true;
		}

		if(isset($setting_file['status']) && $setting_file['status'])
		{
			return true;
		}
		else
		{
			return false;
		}


	}

	public static function send_notif()
	{
		$setting_file = self::setting_file();
		$last_update  = null;
		$last_send_id = null;
		$update_file  = [];

		if(isset($setting_file['last_update']))
		{
			$last_update = $setting_file['last_update'];
		}

		if(isset($setting_file['last_send_id']))
		{
			$last_send_id = $setting_file['last_send_id'];
		}

		if(!$last_update && !$last_send_id)
		{
			$get_sms = \lib\db\sms::need_send_notif();
			$update_file['last_update'] = date("Y-m-d H:i:s");
			if(isset($get_sms['id']))
			{
				$update_file['last_send_id'] = $get_sms['id'];
			}
			self::setting_file($update_file);

			if(isset($get_sms['id']))
			{
				self::send_tg_notif($get_sms);
				return;
			}
		}

		if($last_update)
		{
			if(time() - strtotime($last_update) < (60*5))
			{
				// nothing
				return;
			}
		}

		$get_sms = \lib\db\sms::need_send_notif();

		if(isset($get_sms['id']))
		{
			if(intval($get_sms['id']) === intval($last_send_id))
			{
				return;
			}
			else
			{
				$update_file['last_update'] = date("Y-m-d H:i:s");
				$update_file['last_send_id'] = $get_sms['id'];
				self::setting_file($update_file);
				self::send_tg_notif($get_sms);
			}
		}
		else
		{
			// no new sms
			return;
		}
	}

	public static function send_tg_notif($_sms = null)
	{

		if($_sms === null)
		{
			$_sms = \lib\db\sms::need_send_notif();
		}

		if(!$_sms)
		{
			\dash\notif::info(T_("No new message"));
			return false;
		}

		$tg_msg  = "#SMS ". $_sms['id'];
		$tg_msg  .= " 📲 ". $_sms['togateway'];
		$tg_msg  .= "\n";
		$tg_msg  .= '#user'. $_sms['user_id'];
		$tg_msg  .= ' 💸 '. $_sms['fromnumber'];
		$tg_msg  .= "\n";
		$tg_msg  .= $_sms['text'];
		$tg_msg  .= "\n\n🕗 ". \dash\datetime::fit($_sms['datecreated'], true);

		$chat_id =
		[
			'reza'    => 33263188, // reza
			'javad'   => 46898544, // javad
			'khalili' => 106601863, // khalili
			'sobati'  => 638670211, // sobati
		];

		$boys =
		[
			'989109610612', // reza
			'989357269759', // javad
			'989195191378', // my son
		];

		// to test and debug ;)
		if(isset($_sms['togateway']) && in_array($_sms['togateway'], $boys))
		{
			unset($chat_id['khalili']);
			unset($chat_id['sobati']);
		}

		foreach ($chat_id as $key => $value)
		{
			$tg                 = [];
			$tg['chat_id']      = $value;
			$tg['text']         = $tg_msg;
			$tg['reply_markup'] =
			[
				'inline_keyboard'    =>
				[
					[
						[
							'text'          => 	T_("Review"),
							'callback_data' => 'smsapp_'. $_sms['id'],
						],
					],
				],
			];

			$result = \dash\social\telegram\tg::sendMessage($tg);
		}

	}


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

			$skip =
			[
				'id'    =>  "0",
				'title' =>  T_("Skip this message"),
			];


			$answers = array_merge($answers, $skip);
			return $answers;
		}
	}


	public static function set_group($_smsid, $_group_id)
	{
		if($_smsid && $_group_id)
		{
			$load_sms = self::get_tg_text(1, $_smsid);
			if(isset($load_sms['group_id']))
			{
				// nothing
			}
			else
			{
				\lib\db\sms::update(['group_id' => $_group_id], $_smsid);
			}
		}
	}

	public static function get_answer($_answer_id)
	{
		$load = \lib\db\smsgroupfilter::get(['id' => $_answer_id, 'limit' => 1]);
		return $load;
	}


	public static function set_answer($_smsid, $_answer_id)
	{
		if((string) $_answer_id === '0')
		{
			$post                  = [];
			$post['answertext']    = null;
			$post['receivestatus'] = 'skip';
			$post['dateanswer']    = date("Y-m-d H:i:s");
			$post['sendstatus']    = null;
			$result                = \lib\app\sms::edit($post, \dash\coding::encode($_smsid));

			$update_file                 = [];
			$update_file['last_update']  = date("Y-m-d H:i:s");
			$update_file['last_send_id'] = $_smsid;
			self::setting_file($update_file);

			\dash\notif::clean();
		}
		else
		{
			$load = self::get_answer($_answer_id);

			if(isset($load['text']))
			{
				$load_sms = self::get_tg_text(1, $_smsid);
				if(isset($load_sms['answertext']))
				{
					\dash\notif::error(T_("This message was answered"));
				}
				else
				{
					$post                  = [];
					$post['answertext']    = $load['text'];
					$post['receivestatus'] = 'answerready';
					$post['dateanswer']    = date("Y-m-d H:i:s");
					$post['sendstatus']    = 'awaiting';
					$result                = \lib\app\sms::edit($post, \dash\coding::encode($_smsid));

					$update_file                 = [];
					$update_file['last_update']  = date("Y-m-d H:i:s");
					$update_file['last_send_id'] = $_smsid;
					self::setting_file($update_file);

					\dash\notif::clean();
				}
			}
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
		'receivestatus',
		'sendstatus',
		'amount',
		'group_id',
		'recommend_id',

	];

	public static function chart()
	{
		$now = date("Y-m-d");
		$lastYear = date("Y-m-d", strtotime("-1 year"));

		$get_chart_receive = \lib\db\sms::get_chart_receive($now, $lastYear);
		$get_chart_send    = \lib\db\sms::get_chart_send($now, $lastYear);

		if(!is_array($get_chart_receive) || !is_array($get_chart_send))
		{
			return false;
		}

		// find max count
		$max_array = $get_chart_receive;
		if(count($get_chart_send) > count($get_chart_receive))
		{
			$max_array = $get_chart_receive;
		}

		$date = array_keys($max_array);

		$hi_chart               = [];
		$hi_chart['categories'] = [];
		$hi_chart['send']       = [];
		$hi_chart['receive']    = [];

		foreach ($date as $key => $value)
		{
			array_push($hi_chart['categories'], \dash\datetime::fit($value, null, 'date'));

			if(isset($get_chart_receive[$value]))
			{
				array_push($hi_chart['receive'], intval($get_chart_receive[$value]));
			}
			else
			{
				array_push($hi_chart['receive'], 0);
			}

			if(isset($get_chart_send[$value]))
			{
				array_push($hi_chart['send'], intval($get_chart_send[$value]));
			}
			else
			{
				array_push($hi_chart['send'], 0);
			}
		}

		$hi_chart['categories'] = json_encode($hi_chart['categories'], JSON_UNESCAPED_UNICODE);
		$hi_chart['send']       = json_encode($hi_chart['send'], JSON_UNESCAPED_UNICODE);
		$hi_chart['receive']    = json_encode($hi_chart['receive'], JSON_UNESCAPED_UNICODE);
		return $hi_chart;
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


	public static function chat_list()
	{
		$list = \lib\db\sms::get_chat_list();
		$list = self::chat_last_message($list);
		return $list;
	}


	public static function chat_last_message($_data)
	{
		if(!is_array($_data))
		{
			return false;
		}

		$fromnumber = array_column($_data, 'fromnumber');
		if($fromnumber)
		{
			$fromnumber   = implode(',', $fromnumber);
			$get_last_sms = \lib\db\sms::get_last_message_text($fromnumber);
			j($get_last_sms);
		}
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
		if(!\dash\app::isset_request('receivestatus')) unset($args['receivestatus']);
		if(!\dash\app::isset_request('sendstatus')) unset($args['sendstatus']);
		if(!\dash\app::isset_request('amount')) unset($args['amount']);
		if(!\dash\app::isset_request('answertext')) unset($args['answertext']);
		if(!\dash\app::isset_request('group_id')) unset($args['group_id']);
		if(!\dash\app::isset_request('recommend_id')) unset($args['recommend_id']);
		if(!\dash\app::isset_request('dateanswer')) unset($args['dateanswer']);


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

		$receivestatus = \dash\app::request('receivestatus');
		if($receivestatus && !in_array($receivestatus, ['block', 'awaiting', 'analyze', 'answerready', 'skip']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}

		$sendstatus = \dash\app::request('sendstatus');
		if($sendstatus && !in_array($sendstatus, ['awaiting', 'sendtodevice', 'send', 'deliver']))
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

		$recommend_id = \dash\app::request('recommend_id');
		// $recommend_id = \dash\coding::decode($recommend_id);
		if($recommend_id)
		{
			$get = \lib\db\smsgroup::get(['id' => $recommend_id, 'limit' => 1]);
			if(!isset($get['id']))
			{
				\dash\notif::error(T_("Invalid id"));
				return false;
			}
		}

		$dateanswer = \dash\app::request('dateanswer');

		$args                  = [];
		$args['fromgateway']   = $fromgateway;
		$args['tonumber']      = $tonumber;
		$args['receivestatus'] = $receivestatus;
		$args['sendstatus']    = $sendstatus;
		$args['amount']        = $amount;
		$args['answertext']    = $answertext;
		$args['group_id']      = $group_id;
		$args['recommend_id']  = $recommend_id;
		$args['dateanswer']    = $dateanswer;


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