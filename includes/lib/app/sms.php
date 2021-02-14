<?php
namespace lib\app;

/**
 * Class for sms.
 */
class sms
{
	private static function panel_answer_file()
	{
		return __DIR__.'/autopanelanswer.me.json';
	}


	public static function is_auto_panel_answer()
	{
		return is_file(self::panel_answer_file());
	}


	public static function set_auto_panel_answer()
	{
		if(!self::is_auto_panel_answer())
		{
			\dash\file::write(self::panel_answer_file(), date("Y-m-d H:i:s"));
		}
	}


	public static function unset_auto_panel_answer()
	{
		if(self::is_auto_panel_answer())
		{
			\dash\file::delete(self::panel_answer_file());
		}
	}


	public static function analyze_text($_text)
	{
		$all_group_text = \lib\db\smsgroupfilter::list_analyze_word();
		if(!is_array($all_group_text))
		{
			return false;
		}

		$text_group = [];

		foreach ($all_group_text as $key => $value)
		{
			if(!isset($text_group[$value['group_id']]))
			{
				$text_group[$value['group_id']] = [];
			}

			$text_group[$value['group_id']][] = $value['text'];
		}

		$find = null;
		foreach ($text_group as $group_id => $words)
		{
			foreach ($words as $word)
			{
				if(strpos($_text, $word) !== false)
				{
					$find   = $group_id;
					$not_in = $text_group;
					unset($not_in[$group_id]);
					foreach ($not_in as $not_group_id => $not_words)
					{
						foreach ($not_words as  $not_word)
						{
							if(strpos($_text, $not_word))
							{
								return false;
							}
						}
					}
				}
			}
		}

		if($find)
		{
			$load = \lib\db\smsgroup::get(['id' => $find, 'limit' => 1]);
			return $load;
		}

		return false;
	}

	// change status of some sms has set on waitingtoautosend by check dateanswer is left 60 min
	public static function send_auto_answered()
	{
		$date = date("Y-m-d H:i:s", time() - (60*1));
		\lib\db\sms::send_auto_answered($date);
	}


	public static function dashboard_detail($_gateway = null)
	{

		$result                = [];
		$result['status']      = \content_api\v6\smsapp\controller::status();

		$day                   = [];
		$day['send']           = \lib\db\sms::get_count_sms('day', 'send', $_gateway);
		$day['send_bulk']      = $day['send']; // \lib\db\sms::get_count_sms('day', 'send', $_gateway, true);

		$day['receive']        = \lib\db\sms::get_count_sms('day', 'receive', $_gateway);
		$day['receive_bulk']   = $day['receive']; // \lib\db\sms::get_count_sms('day', 'receive', $_gateway, true);
		$day['date']           = \dash\datetime::fit(null, true, 'date');

		$week                  = [];
		$week['send']          = \lib\db\sms::get_count_sms('week', 'send', $_gateway);
		$week['send_bulk']     = $week['send']; // \lib\db\sms::get_count_sms('week', 'send', $_gateway, true);

		$week['receive']       = \lib\db\sms::get_count_sms('week', 'receive', $_gateway);
		$week['receive_bulk']  = $week['receive']; // \lib\db\sms::get_count_sms('week', 'receive', $_gateway, true);

		$month                 = [];
		$month['send']         = \lib\db\sms::get_count_sms('month', 'send', $_gateway);
		$month['send_bulk']    = $month['send']; // \lib\db\sms::get_count_sms('month', 'send', $_gateway, true);

		$month['receive']      = \lib\db\sms::get_count_sms('month', 'receive', $_gateway);
		$month['receive_bulk'] = $month['receive']; // \lib\db\sms::get_count_sms('month', 'receive', $_gateway, true);

		$total                 = [];
		if(\dash\url::content() === 'api')
		{
			$total['send']         = 73411;
			$total['send_bulk']    = $total['send']; // \lib\db\sms::get_count_sms('total', 'send', $_gateway, true);

			$total['receive']      = 596898;
			$total['receive_bulk'] = $total['receive']; // \lib\db\sms::get_count_sms('total', 'receive', $_gateway, true);
		}
		else
		{
			$total['send']         = \lib\db\sms::get_count_sms('total', 'send', $_gateway);
			$total['send_bulk']    = $total['send']; // \lib\db\sms::get_count_sms('total', 'send', $_gateway, true);

			$total['receive']      = \lib\db\sms::get_count_sms('total', 'receive', $_gateway);
			$total['receive_bulk'] = $total['receive']; // \lib\db\sms::get_count_sms('total', 'receive', $_gateway, true);
		}


		$result['day']      = $day;
		$result['week']     = $week;
		$result['month']    = $month;
		$result['total']    = $total;

		return $result;
	}


	public static function dashboard_quick($_gateway = null)
	{

		$result                = [];
		$result['status']      = \content_api\v6\smsapp\controller::status();
		$day['date']           = \dash\datetime::fit(null, true, 'date');

		$day                   = [];
		$day['send']           = \lib\db\sms::get_count_sms('day', 'send', $_gateway);
		$day['receive']        = \lib\db\sms::get_count_sms('day', 'receive', $_gateway);

		$total                 = [];
		$total['send']         = \lib\db\sms::get_count_sms('total', 'send', $_gateway);
		$total['receive']      = \lib\db\sms::get_count_sms('total', 'receive', $_gateway);

		$result['day']      = $day;
		$result['total']    = $total;

		return $result;
	}


	public static function status_sms_count($_args = [])
	{
		$result              = [];
		$result['all']       = 0;
		$result['recommend'] = 0;
		$result['send']      = [];
		$result['receive']   = [];

		$result['shenasaee_shode']   = intval(\lib\db\sms::count_shenasaee_shode($_args));
		$result['shenasaee_nashode'] = intval(\lib\db\sms::count_shenasaee_nashode($_args));

		$count_recommend     = \lib\db\sms::count_recommend($_args);

		if(is_array($count_recommend))
		{
			foreach ($count_recommend as $key => $value)
			{
				$result['recommend'] += intval($value['count']);
			}
		}

		$count_receivestatus = \lib\db\sms::count_receivestatus($_args);
		if(is_array($count_receivestatus))
		{
			foreach ($count_receivestatus as $key => $value)
			{
				if($value['receivestatus'] === 'awaiting')
				{
					$result['receive'][$value['receivestatus']] = intval($value['count']);
				}
				else
				{
					$result['receive'][$value['receivestatus']] = intval($value['count']);
				}
			}
		}
		$count_sendstatus    = \lib\db\sms::count_sendstatus($_args);
		if(is_array($count_sendstatus))
		{
			foreach ($count_sendstatus as $key => $value)
			{
				$result['send'][$value['sendstatus']] = intval($value['count']);
			}
		}
		// $count_all     = \lib\db\sms::get_count($_args);
		// $result['all'] = $count_all;
		$result['lastconnected'] = \lib\app\sms::lastconnected();

		return $result;

	}

	public static function lastconnected($_time = null)
	{
		$setting_file = self::setting_file();
		if($_time)
		{
			$time =
			[
				'lastconnected' => time(),
			];
			self::setting_file($time);
			return true;
		}


		if(isset($setting_file['lastconnected']) && $setting_file['lastconnected'])
		{
			return $setting_file['lastconnected'];
		}
		else
		{
			return null;
		}

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


	public static function send_sms_panel()
	{
		$list = \lib\db\sms::get_sms_panel_not_send();


		if(!is_array($list) || !$list)
		{
			return;
		}

		$all_id = array_column($list, 'id');
		if($all_id)
		{
			\lib\db\sms::update_where(['sendstatus' => 'sendbypanel'], ['id' => ['IN', "(". implode($all_id, ','). ")"]]);
		}

		foreach ($list as $key => $value)
		{
			\dash\utility\sms::send($value['fromnumber'], $value['answertext'], ['localid' => '1000'. $value['id']]);
			\lib\db\sms::update(['sendstatus' => 'sendbypanel', 'tonumber' => $value['fromnumber']], $value['id']);
		}
	}

	public static function send_tg_notif($_sms = null)
	{
		return;

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
			// 'khalili' => 106601863, // khalili
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
		if(\dash\url::content() === 'hook')
		{
			$skip =
			[
				'id'    =>  "skip",
				'title' =>  '⚠️ '. T_("Skip"),
			];
			$smsgroup[] = $skip;
		}
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
			if(\dash\url::content() === 'hook')
			{
				$skip =
				[
					'id'    =>  "skip",
					'text'  =>  '⚠️ '. T_("Skip"),
				];
				$answers[] = $skip;
			}
			return $answers;
		}
	}


	public static function recommend_answer($_recommand_id, $_answer_id, $_fromgateway)
	{
		$load = self::get_answer($_answer_id);



		if(isset($load['text']))
		{

			$where =
			[
				'recommend_id'  => $_recommand_id,
				'receivestatus' => 'awaiting',
				'sendstatus'    => null,
			];

			$set =
			[
				'answertext'      => $load['text'],
				'answertextcount' => mb_strlen($load['text']),
				'receivestatus'   => 'answerready',
				'dateanswer'      => date("Y-m-d H:i:s"),
				'sendstatus'      => 'awaiting',
				'group_id'        => $load['group_id'],
			];

			// from_smspanel
			if($_fromgateway === 'from_sender')
			{
				$result = \lib\db\sms::update_where_sender($set, $where);
			}
			else
			{
				$set['receivestatus'] = 'sendtopanel';
				$result = \lib\db\sms::update_where($set, $where);
			}


			return $result;

		}
	}

	public static function set_group($_smsid, $_group_id)
	{
		if((string) $_group_id === 'skip')
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
			return;
		}

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
		if((string) $_answer_id === 'skip')
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
					$post                    = [];
					$post['answertext']      = $load['text'];
					$post['answertextcount'] = mb_strlen($load['text']);
					$post['fromgateway']     = $load['togateway'];
					$post['receivestatus']   = 'answerready';
					$post['dateanswer']      = date("Y-m-d H:i:s");
					$post['sendstatus']      = 'awaiting';
					$result                  = \lib\app\sms::edit($post, \dash\coding::encode($_smsid));

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

	public static function chart($_type = null, $_raw = false)
	{
		$now = date("Y-m-d");
		if($_type === 'month')
		{
			$lastYear = date("Y-m-d", strtotime("-30 days"));
		}
		elseif ($_type === '2year')
		{
			$lastYear = date("Y-m-d", strtotime("-2 year"));
		}
		else
		{
			$lastYear = date("Y-m-d", strtotime("-1 year"));
		}

		$get_chart_receive    = \lib\db\sms::get_chart_receive($now, $lastYear);
		$get_chart_send       = \lib\db\sms::get_chart_send($now, $lastYear);
		$get_chart_send_panel = \lib\db\sms::get_chart_send_panel($now, $lastYear);

		if(!is_array($get_chart_receive) || !is_array($get_chart_send) || !is_array($get_chart_send_panel))
		{
			return false;
		}

		// find max count
		$max_array = $get_chart_receive;
		if(count($get_chart_send) > count($get_chart_receive))
		{
			$max_array = $get_chart_receive;
		}

		if(count($get_chart_send_panel) > count($max_array))
		{
			$max_array = $get_chart_send_panel;
		}

		$date = array_keys($max_array);

		$hi_chart               = [];
		$hi_chart['categories'] = [];
		$hi_chart['send']       = [];
		$hi_chart['sendpanel']  = [];
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

			if(isset($get_chart_send_panel[$value]))
			{
				array_push($hi_chart['sendpanel'], intval($get_chart_send_panel[$value]));
			}
			else
			{
				array_push($hi_chart['sendpanel'], 0);
			}
		}

		if($_raw)
		{
			return $hi_chart;
		}

		$hi_chart['categories'] = json_encode($hi_chart['categories'], JSON_UNESCAPED_UNICODE);
		$hi_chart['send']       = json_encode($hi_chart['send'], JSON_UNESCAPED_UNICODE);
		$hi_chart['sendpanel']  = json_encode($hi_chart['sendpanel'], JSON_UNESCAPED_UNICODE);
		$hi_chart['receive']    = json_encode($hi_chart['receive'], JSON_UNESCAPED_UNICODE);
		return $hi_chart;
	}


	public static function chart_raw($_type = null)
	{
		$list = self::chart($_type, true);
		$result = [];
		foreach ($list['categories'] as $key => $value)
		{
			$result[] =
			[
				'date'      => $value,
				'send'      => @$list['send'][$key],
				'sendpanel' => @$list['sendpanel'][$key],
				'receive'   => @$list['receive'][$key],
			];
		}

		$result = array_reverse($result);

		return $result;
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

	public static function edit_multi($_args, $_ids)
	{
		$ids = implode(',', $_ids);
		$update = \lib\db\sms::update_multi($_args, $ids);
		return $update;

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
		if(!\dash\app::isset_request('answertextcount')) unset($args['answertextcount']);
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
		if($fromgateway)
		{
			$fromgateway = \dash\utility\convert::to_en_number($fromgateway);
			if(!\dash\utility\filter::mobile($fromgateway))
			{
				if(!in_array(intval($fromgateway), [10006660066600]))
				{
					\dash\notif::error(T_("Invalid gateway"));
					return false;
				}
			}

		}
		$tonumber    = \dash\app::request('tonumber');

		$receivestatus = \dash\app::request('receivestatus');
		if($receivestatus && !in_array($receivestatus, ['block', 'awaiting', 'analyze', 'answerready', 'skip', 'sendtopanel']))
		{
			\dash\notif::error(T_("Invalid status"));
			return false;
		}

		$sendstatus = \dash\app::request('sendstatus');
		if($sendstatus && !in_array($sendstatus, ['awaiting', 'sendtodevice', 'send', 'deliver', 'sendbypanel']))
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
		$answertextcount = \dash\app::request('answertextcount');

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
		$args['answertextcount']    = $answertextcount;
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


				case 'receivestatus':
					$tvalue = T_(ucfirst($value));
					if($value === 'skip')
					{
						$tvalue = T_('Archive');
					}

					$result[$key]      = $value;
					$result['t'. $key] = $tvalue;
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