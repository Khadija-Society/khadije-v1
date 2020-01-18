<?php
namespace content_agent\send\billing;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title(T_("Servant Profile"));

		\dash\data::page_pictogram('magic');

		$missionary_id = \dash\data::dataRow_missionary_id();

		if($missionary_id)
		{
			$userDetail = \dash\app\user::get($missionary_id);
			\dash\data::userDetail($userDetail);

		}

		self::tempText();
	}


	public static function tempText()
	{
		$payamount = \dash\data::dataRow_payamount();

		if(!$payamount)
		{
			return;
		}

		$displayname = \dash\data::dataRow_missionary_displayname() ? \dash\data::dataRow_missionary_displayname() : '';
		$firstname   = \dash\data::dataRow_missionary_firstname() ? \dash\data::dataRow_missionary_firstname() : '';
		$lastname    = \dash\data::dataRow_missionary_lastname() ? \dash\data::dataRow_missionary_lastname() : '';
		$paydate     = \dash\data::dataRow_paydate() ? \dash\data::dataRow_paydate() : '';
		$paybank     = \dash\data::dataRow_paybank() ? \dash\data::dataRow_paybank() : '';
		$paytype     = \dash\data::dataRow_paytype() ? \dash\data::dataRow_paytype() : '';
		$paynumber   = \dash\data::dataRow_paynumber() ? \dash\data::dataRow_paynumber() : '';

		$payamount = \dash\utility\human::fitNumber($payamount);
		$paynumber = \dash\utility\human::fitNumber($paynumber, false);


		$tempText = "";
		$tempText .= " مبلغ ";
		$tempText .= $payamount;
		$tempText .= " تومان ";

		if($paydate)
		{
			$tempText .= " در تاریخ ";
			$tempText .= \dash\utility\jdate::date("l j F Y", $paydate);
		}

		if($paybank || $paynumber)
		{
			$tempText .= " به ";
		}

		$tempText .= $paytype;
		if($paynumber)
		{
			$tempText .= " شماره ";
			$tempText .= $paynumber;
		}

		if($paybank)
		{
			$tempText .= " نزد بانک ";
			$tempText .= $paybank;
		}
		$tempText .= " پراخت شد. ";

		if($paynumber && $paybank)
		{

			$tempText .= " نام صاحب حساب ";
			if($firstname || $lastname)
			{
				$tempText .= $firstname. ' '. $lastname;
			}
			else
			{
				$tempText .= $displayname;
			}
		}

		\dash\data::tempText($tempText);
	}
}
?>