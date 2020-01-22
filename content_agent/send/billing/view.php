<?php
namespace content_agent\send\billing;


class view
{
	public static function config()
	{
		// \dash\permission::access('agentServantProfileView');
		\dash\data::page_title("مالی");

		\dash\data::page_pictogram('card');

		\dash\data::badge_link(\dash\url::this(). \dash\data::xCityStart());
		\dash\data::badge_text(T_('Back'));


		$missionary_id = \dash\data::dataRow_missionary_id();

		if($missionary_id)
		{
			$userDetail = \dash\app\user::get($missionary_id);
			\dash\data::userDetail($userDetail);

		}

		self::tempText();
	}


	public static function tempText($_xtime = null)
	{
		$payamount = \dash\data::dataRow_payamount();



		$displayname             = \dash\data::dataRow_missionary_displayname() ? \dash\data::dataRow_missionary_displayname() : '';
		$mobile                  = \dash\data::dataRow_missionary_mobile() ? \dash\data::dataRow_missionary_mobile() : '';
		$gender                  = \dash\data::dataRow_missionary_gender() ? \dash\data::dataRow_missionary_gender() : '';
		$nationalcode            = \dash\data::dataRow_missionary_nationalcode() ? \dash\data::dataRow_missionary_nationalcode() : '';
		$firstname               = \dash\data::dataRow_missionary_firstname() ? \dash\data::dataRow_missionary_firstname() : '';
		$lastname                = \dash\data::dataRow_missionary_lastname() ? \dash\data::dataRow_missionary_lastname() : '';
		$paydate                 = \dash\data::dataRow_paydate() ? \dash\data::dataRow_paydate() : '';
		$paybank                 = \dash\data::dataRow_paybank() ? \dash\data::dataRow_paybank() : '';
		$paytype                 = \dash\data::dataRow_paytype() ? \dash\data::dataRow_paytype() : '';
		$paynumber               = \dash\data::dataRow_paynumber() ? \dash\data::dataRow_paynumber() : '';

		$displayname_adminoffice = \dash\data::dataRow_adminoffice_displayname() ? \dash\data::dataRow_adminoffice_displayname() : '';
		$firstname_adminoffice   = \dash\data::dataRow_adminoffice_firstname() ? \dash\data::dataRow_adminoffice_firstname() : '';
		$gender_adminoffice      = \dash\data::dataRow_adminoffice_gender() ? \dash\data::dataRow_adminoffice_gender() : '';
		$lastname_adminoffice    = \dash\data::dataRow_adminoffice_lastname() ? \dash\data::dataRow_adminoffice_lastname() : '';
		$mobile_adminoffice      = \dash\data::dataRow_adminoffice_mobile() ? \dash\data::dataRow_adminoffice_mobile() : '';

		$payamount               = \dash\utility\human::fitNumber($payamount);
		$paynumber               = \dash\utility\human::fitNumber($paynumber, false);
		$place_title             = \dash\data::dataRow_place_title();
		$place_address           = \dash\data::dataRow_place_address();

		if($paydate)
		{
			$paydate = \dash\utility\jdate::date("l j F Y", $paydate);
		}

		if($firstname || $lastname)
		{
			$myName = $firstname. ' '. $lastname;
		}
		else
		{
			$myName = $displayname;
		}


		if($firstname_adminoffice || $lastname_adminoffice)
		{
			$myName_adminoffice = $firstname_adminoffice. ' '. $lastname_adminoffice;
		}
		else
		{
			$myName_adminoffice = $displayname_adminoffice;
		}

		$myGender_adminoffice = null;
		if($gender_adminoffice === 'male')
		{
			$myGender_adminoffice = 'جناب آقای';
		}
		elseif($gender_adminoffice === 'female')
		{
			$myGender_adminoffice = 'سرکار خانم';
		}


		$mobile = \dash\utility\human::fitNumber($mobile, false);
		$mobile_adminoffice = \dash\utility\human::fitNumber($mobile_adminoffice, false);
		$nationalcode = \dash\utility\human::fitNumber($nationalcode, false);

		$myGender = null;
		if($gender === 'male')
		{
			$myGender = 'جناب آقای';
		}
		elseif($gender === 'female')
		{
			$myGender = 'سرکار خانم';
		}

		$tempText = "هزینه ایاب و ذهاب جلسه سخنرانی در زائر سرای $place_title در تاریخ $paydate $myGender $myName به کد ملی $nationalcode شماره تماس  $mobile";

		if($payamount)
		{
			\dash\data::tempText($tempText);
		}

		if(!$_xtime)
		{
			$_xtime = '؟؟';
		}

		$smsText = "سلام و ادب و احترام
یادآوری
امروز ساعت $_xtime $place_title واقع در $place_address شماره رابط $mobile_adminoffice $myGender_adminoffice $myName_adminoffice
جسارتا هزینه ایاب و ذهاب واریز گردید.سپاس فراوان";
		\dash\data::smsText($smsText);
		return;


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