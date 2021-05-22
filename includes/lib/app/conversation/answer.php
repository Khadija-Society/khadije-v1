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

		$fromgateway = null;
		if(isset($_args['fromgateway']) && is_string($_args['fromgateway']))
		{
			$fromgateway = $_args['fromgateway'];
		}


		$get_last_record_mobile = \lib\db\conversation\get::last_record_mobile($_mobile);

		if(!isset($get_last_record_mobile['id']))
		{
			\dash\notif::error(T_("Data not found"));
			return false;
		}

		if(isset($get_last_record_mobile['answertext']) && $get_last_record_mobile['answertext'])
		{
			\dash\notif::error(T_("Can not answer to this number"));
			return false;
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

			if($fromgateway === 'panel')
			{
				$post['receivestatus'] = 'sendtopanel';
			}

			$update_record = \lib\db\conversation\update::record($update, $get_last_record_mobile['id']);


		}

		\dash\notif::ok(T_("Answer sended"));


		return true;

	}
}
?>