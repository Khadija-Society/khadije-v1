<?php
namespace lib\tg;
// use telegram class as bot
use \dash\social\telegram\tg as bot;
use \dash\social\telegram\step;
use \dash\social\telegram\hook;
use \dash\social\telegram\keyboard as kbd;

class smsapp
{
	public static function detector($_cmd)
	{
		$myCommand = $_cmd['commandRaw'];
		if(bot::isCallback())
		{
			$myCommand = substr($myCommand, 3);
		}
		elseif(bot::isInline())
		{
			$myCommand = substr($myCommand, 3);
		}
		// remove command from start
		if(substr($myCommand, 0, 1) == '/')
		{
			$myCommand = substr($myCommand, 1);
		}
		// remove survey from start of command
		// and detect survey No
		$smsNo = null;
		if(substr($myCommand, 0, 7) === 'smsapp_')
		{
			$smsNo = substr($myCommand, 7);
		}
		else
		{
			switch ($myCommand)
			{
				case 'sms':
				case 'Sms':
				case 'SMS':
					// show list of survey
					self::sms();
					return true;
					break;

				default:
					return false;
					break;
			}
		}

		// remove botname from surveyNo if exist
		$smsNo = strtok($smsNo, '@');
		// check if survey id is not exist show list
		if(!$smsNo)
		{
			self::empty();
			return false;
		}
		// if code is not valid show related message
		// if(!\dash\coding::is($smsNo))
		// {
		// 	self::requireCode();
		// 	return false;
		// }
		// detect opt
		$myGroup = null;
		if(isset($_cmd['optionalRaw']) && $_cmd['optionalRaw'])
		{
			$myGroup = $_cmd['optionalRaw'];
		}
		// detect arg
		$myAnswer = null;
		if(isset($_cmd['argumentRaw']) && $_cmd['argumentRaw'])
		{
			$myAnswer = $_cmd['argumentRaw'];
		}


		if(bot::isCallback())
		{
			// transfer conditions here

		}
		else
		{
			// do nothing
		}


		if($myGroup && $myAnswer)
		{
			// step3
			// remove all keyboard
			return self::finishMsg($smsNo, $myGroup, $myAnswer);
		}
		elseif($myGroup)
		{
			// step2
			// show answer btn
			return self::s2_fillAnswers($smsNo, $myGroup);
		}
		elseif($myGroup === null)
		{
			// step1
			// show group btn
			return self::s1_fillGroups($smsNo);
		}
	}



	public static function s1_fillGroups($_smsNo)
	{
		bot::ok();
		$groupList  = \lib\app\sms::group_list();

		if($groupList)
		{
			$groupArr = [];
			foreach ($groupList as $gKey => $gValue)
			{
				$groupArr[] =
				[
					'text'          => $gValue['title'],
					'callback_data' => 'smsapp_'. $_smsNo . ' '. $gValue['id']
				];
			}

			$result = [ 'reply_markup' => kbd::draw($groupArr, null, 'inline_keyboard') ];


			// if start with callback answer callback
			if(bot::isCallback())
			{
				$callbackResult =
				[
					'text' => 'SMS '. $_smsNo,
				];
				bot::answerCallbackQuery($callbackResult);
			}

			if(hook::message_id())
			{
				bot::editMessageReplyMarkup($result);
			}
			else
			{
				// for debug
				bot::sendMessage($result);
			}
		}
		else
		{
			if(bot::isCallback())
			{
				$callbackResult =
				[
					'text' => T_("Please define some group!"),
					'show_alert' => true,
				];
				bot::answerCallbackQuery($callbackResult);
			}
		}
	}



	public static function s2_fillAnswers($_smsNo, $_group)
	{
		bot::ok();
		// try to save selected group
		\lib\app\sms::set_group($_smsNo, $_group);

		$answerList = \lib\app\sms::answer_list($_group);

		if($answerList)
		{
			$answerArr = [];
			foreach ($answerList as $gKey => $gValue)
			{
				$answerArr[] =
				[
					'text'          => $gValue['text'],
					'callback_data' => 'smsapp_'. $_smsNo . ' '. $_group. ' '. $gValue['id']
				];
			}

			$updatedText = hook::message('text');
			$updatedText .= "\n";
			$groupDetail = \lib\app\sms::get_group($_group);
			if(isset($groupDetail['title']))
			{
				$updatedText .= "🚩 <b>". $groupDetail['title'] ."</b>";
			}

			$result =
			[
				'text' => $updatedText,
				'reply_markup' => kbd::draw($answerArr, null, 'inline_keyboard', 'id', 'text')
			];


			// if start with callback answer callback
			if(bot::isCallback())
			{
				$callbackResult =
				[
					'text' => 'SMS '. $_smsNo,
				];
				bot::answerCallbackQuery($callbackResult);
			}

			if(hook::message_id())
			{
				bot::editMessageText($result);
			}
			else
			{
				// for debug
				bot::sendMessage($result);
			}
		}
		else
		{
			if(bot::isCallback())
			{
				$callbackResult =
				[
					'text' => T_("Please define some answer!"),
					'show_alert' => true,
				];
				bot::answerCallbackQuery($callbackResult);
			}
		}
	}



	public static function finishMsg($_smsNo, $_group, $_answer)
	{
		bot::ok();

		if($_smsNo)
		{
			// try to save selected answer
			\lib\app\sms::set_answer($_smsNo, $_answer, $_group);

			$updatedText  = hook::message('text');
			$updatedText  .= "\n";
			$answerDetail = \lib\app\sms::get_answer($_answer);
			if(isset($answerDetail['text']))
			{
				$updatedText .= "📣 <b>". $answerDetail['text'] ."</b>";
			}

			// remove keyboard of old messages
			$result =
			[
				'text' => $updatedText,
				'reply_markup' =>
				[
					'inline_keyboard' => []
				]
			];

			// if start with callback answer callback
			if(bot::isCallback())
			{
				$callbackResult =
				[
					'text' => T_("SMS"). ' '. $_smsNo,
				];
				bot::answerCallbackQuery($callbackResult);
			}


			if(hook::message_id())
			{
				bot::editMessageText($result);
			}
			else
			{
				// for debug
				bot::sendMessage($result);
			}

			// send another notif at end
			\lib\app\sms::send_tg_notif();
		}
		else
		{
			if(bot::isCallback())
			{
				$callbackResult =
				[
					'text' => T_("We can't find detail of this sms!"),
					'show_alert' => true,
				];
				bot::answerCallbackQuery($callbackResult);
			}
		}
	}



	public static function requireCode()
	{
		bot::ok();
		$msg = T_("We need sms code!")." 🙁";

		// if start with callback answer callback
		if(bot::isCallback())
		{
			$callbackResult =
			[
				'text' => $msg,
			];
			bot::answerCallbackQuery($callbackResult);
		}

		$result =
		[
			'text' => $msg,
		];
		bot::sendMessage($result);
	}


	public static function empty()
	{
		bot::ok();
		$msg = T_("SMS number is invalid!")." 🙁";

		// if start with callback answer callback
		if(bot::isCallback())
		{
			$callbackResult =
			[
				'text' => $msg,
			];
			bot::answerCallbackQuery($callbackResult);
		}

		$result =
		[
			'text' => $msg,
		];
		bot::sendMessage($result);
	}


	public static function sms()
	{
		// get list of unanswered sms
		\lib\app\sms::send_tg_notif();
	}
}
?>