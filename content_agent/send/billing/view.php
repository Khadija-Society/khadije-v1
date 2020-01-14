<?php
namespace content_agent\send\billing;


class view
{
	public static function config()
	{
		\dash\permission::access('agentServantProfileView');
		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('magic');

		$user_id = \dash\data::sendDetail_user_id();
		if($user_id)
		{
			$userDetail = \dash\app\user::get($user_id);
			\dash\data::userDetail($userDetail);

		}

		self::tempText();
	}


	private static function tempText()
	{
		$payamount = \dash\data::sendDetail_payamount();

		if(!$payamount)
		{
			return;
		}

		$displayname = \dash\data::sendDetail_displayname() ? \dash\data::sendDetail_displayname() : '';
		$firstname   = \dash\data::sendDetail_firstname() ? \dash\data::sendDetail_firstname() : '';
		$lastname    = \dash\data::sendDetail_lastname() ? \dash\data::sendDetail_lastname() : '';
		$paydate     = \dash\data::sendDetail_paydate() ? \dash\data::sendDetail_paydate() : '';
		$paybank     = \dash\data::sendDetail_paybank() ? \dash\data::sendDetail_paybank() : '';
		$paytype     = \dash\data::sendDetail_paytype() ? \dash\data::sendDetail_paytype() : '';
		$paynumber   = \dash\data::sendDetail_paynumber() ? \dash\data::sendDetail_paynumber() : '';

		$payamount = \dash\utility\human::fitNumber($payamount);
		$paynumber = \dash\utility\human::fitNumber($paynumber, false);


		$tempText = "";
		$tempText .= " مبلغ ";
		$tempText .= $payamount;
		$tempText .= " تومان ";
		$tempText .= " در تاریخ ";
		$tempText .= \dash\utility\jdate::date("l j F Y", $paydate);
		$tempText .= " به ";
		$tempText .= $paytype;
		$tempText .= " شماره ";
		$tempText .= $paynumber;
		$tempText .= " نزد بانک ";
		$tempText .= $paybank;
		$tempText .= " واریز شد. ";
		$tempText .= " نام صاحب حساب ";
		if($firstname || $lastname)
		{
			$tempText .= $firstname. ' '. $lastname;
		}
		else
		{
			$tempText .= $displayname;
		}

		\dash\data::tempText($tempText);
	}
}
?>