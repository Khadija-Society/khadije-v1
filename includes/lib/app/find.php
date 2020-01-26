<?php
namespace lib\app;

class find
{
	public static function q($_q)
	{
		$mobile       = null;
		$nationalcode = null;

		if(\dash\utility\filter::nationalcode($_q))
		{
			$nationalcode = $_q;
		}
		elseif(\dash\utility\filter::mobile($_q))
		{
			$mobile = $_q;
		}

		if(!$mobile && !$nationalcode)
		{
			\dash\notif::error("لطفا شماره موبایل یا کد ملی را به صورت صحیح وارد کنید");
			return false;
		}

		if($nationalcode)
		{
			return self::nationalcode($nationalcode);
		}
		else
		{
			return self::mobile($mobile);
		}
	}


	public static function nationalcode($_nationalcode)
	{
		if(!\dash\utility\filter::nationalcode($_nationalcode))
		{
			return false;
		}

		$user_detail = \dash\db\users::get(['nationalcode' => $_nationalcode, 'limit' => 1]);
		if(isset($user_detail['id']))
		{
			return self::user_id($user_detail['id'], $user_detail['mobile'], $user_detail['nationalcode'], $user_detail);
		}
		else
		{
			\dash\notif::error(T_("User not found"));
			return false;
		}
	}


	public static function mobile($_mobile)
	{
		$_mobile = \dash\utility\filter::mobile($_mobile);
		if(!$_mobile)
		{
			return false;
		}

		$user_detail = \dash\db\users::get_by_mobile($_mobile);
		if(isset($user_detail['id']))
		{
			return self::user_id($user_detail['id'], $user_detail['mobile'], $user_detail['nationalcode'], $user_detail);
		}
		else
		{
			\dash\notif::error(T_("User not found"));
			return false;
		}

	}


	public static function user_id($_user_id, $_mobile, $_nationalcode, $_user_detail = null)
	{
		$result                   = [];
		$result['karevani']       = \lib\db\find::karevani($_user_id);
		$result['karevani_admin'] = \lib\db\find::karevani_admin($_user_id);

		if($_nationalcode)
		{
			$result['nationalcode']              = \lib\db\find::nationalcode($_nationalcode);
			$result['mokeb_nationalcode']        = \lib\db\find::mokeb_nationalcode($_nationalcode);
			$result['koyemohabbat_nationalcode'] = \lib\db\find::koyemohabbat_nationalcode($_nationalcode);
			$result['samtekhoda_nationalcode']   = \lib\db\find::samtekhoda_nationalcode($_nationalcode);
		}

		if($_mobile)
		{
			$result['mokeb_mobile']          = \lib\db\find::mokeb_mobile($_mobile);
			$result['koyemohabbat_mobile']   = \lib\db\find::koyemohabbat_mobile($_mobile);
			$result['samtekhoda_mobile']     = \lib\db\find::samtekhoda_mobile($_mobile);
		}

		$result['agent']          = \lib\db\find::agent($_user_id);

		return $result;
	}


}
?>