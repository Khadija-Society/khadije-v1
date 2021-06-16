<?php
namespace lib\app\conversation;

/**
 * Class for sms.
 */
class answer
{

	public static function set_answer($_args, $_mobile)
	{

		$group_id = null;
		if(isset($_args['group_id']) && is_numeric($_args['group_id']))
		{
			$group_id = $_args['group_id'];
		}

		if($group_id)
		{
			$check_group = \lib\db\smsgroup::get(['id' => $group_id, 'limit' => 1]);
			if(isset($check_group['id']))
			{
				// ok
			}
			else
			{
				\dash\notif::error(T_("Invalid group"));
				return false;
			}
		}

		$answer = null;
		if(isset($_args['answer']) && is_string($_args['answer']))
		{
			$answer = $_args['answer'];
		}

		if(!$answer)
		{
			\dash\notif::error(T_("Answer is required"));
			return false;
		}

		if(strpos($answer, ':name:') !== false)
		{
			$user_displayname = \lib\db\conversation\search::get_one_user_displayname($_mobile);

			$answer = str_replace(':name:', $user_displayname, $answer);
		}

		$fromgateway = null;
		if(isset($_args['fromgateway']) && is_string($_args['fromgateway']))
		{
			$fromgateway = $_args['fromgateway'];
		}


		$get_last_record_mobile = \lib\db\conversation\get::last_record_mobile($_mobile, \lib\app\platoon\tools::get_index_locked());

		if(!isset($get_last_record_mobile['id']))
		{
			\dash\notif::error(T_("Data not found"));
			return false;
		}


		if(isset($get_last_record_mobile['answertext']) && $get_last_record_mobile['answertext'])
		{
			$insert_new_sms =
			[
				'fromnumber'            => a($get_last_record_mobile, 'fromnumber'),
				'togateway'             => a($get_last_record_mobile, 'togateway'),
				'fromgateway'           => a($get_last_record_mobile, 'fromgateway'),
				'text'                  => null,
				'smscount'              => 0,
				'tonumber'              => a($get_last_record_mobile, 'tonumber'),
				'user_id'               => a($get_last_record_mobile, 'user_id'),
				'date'                  => date("Y-m-d H:i:s"),
				'datecreated'           => date("Y-m-d H:i:s"),
				'datemodified'          => null,
				'uniquecode'            => null,
				'receivestatus'         => 'answerready',
				'sendstatus'            => 'waitingtoautosend',
				'amount'                => null,
				'answertext'            => $answer,
				'answertextcount'       => mb_strlen($answer),
				'group_id'              => null,
				'recommend_id'          => null,
				'datereceive'           => a($get_last_record_mobile, 'datereceive'),
				'dateanswer'            => date("Y-m-d H:i:s"),
				'datesend'              => null,
				'brand'                 => a($get_last_record_mobile, 'brand'),
				'model'                 => a($get_last_record_mobile, 'model'),
				'simcartserial'         => a($get_last_record_mobile, 'simcartserial'),
				'smsmessageid'          => a($get_last_record_mobile, 'smsmessageid'),
				'userdata'              => a($get_last_record_mobile, 'userdata'),
				'md5'                   => a($get_last_record_mobile, 'md5'),
				'mobile_id'             => a($get_last_record_mobile, 'mobile_id'),
				'conversation_answered' => 1,
			];

			$insert_new_sms['group_id']        = $group_id;
			$insert_new_sms['answertext']      = $answer;
			$insert_new_sms['answertextcount'] = mb_strlen($answer);
			$insert_new_sms['fromgateway']     = $fromgateway;
			$insert_new_sms['sendstatus']      = 'awaiting';
			$insert_new_sms['dateanswer']      = date("Y-m-d H:i:s");
			$insert_new_sms['receivestatus']   = 'answerready';

			if($fromgateway === '10006660066600')
			{
				$insert_new_sms['receivestatus'] = 'sendtopanel';
			}

			\lib\db\sms::insert($insert_new_sms);


		}
		else
		{

			// update current record and send to panel
			$update                    = [];
			$update['group_id']        = $group_id;
			$update['answertext']      = $answer;
			$update['answertextcount'] = mb_strlen($answer);
			$update['fromgateway']     = $fromgateway;
			$update['sendstatus']      = 'awaiting';
			$update['dateanswer']      = date("Y-m-d H:i:s");
			$update['receivestatus']   = 'answerready';

			if($fromgateway === '10006660066600')
			{
				$update['receivestatus'] = 'sendtopanel';
			}

			$update_record = \lib\db\conversation\update::record($update, $get_last_record_mobile['id']);


		}

		\dash\notif::ok(T_("Answer sended"));


		return true;

	}
}
?>