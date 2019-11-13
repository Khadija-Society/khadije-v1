<?php
namespace content_mokeb\add;


class view
{
	public static function config()
	{

		$full = 0;
		$free = 0;

		$capacity = \dash\data::mokebDetail_capacity();
		if($capacity)
		{
			$full = count(\lib\app\mokebuser::list_of_free(\dash\url::child(), true));
			$free = intval($capacity) - $full;
		}

		$myTitle = "موکب  ". \dash\data::mokebDetail_title();
		$myTitle .= " / ظرفیت ". \dash\utility\human::fitNumber($capacity);
		$myTitle .= " / پر ". \dash\utility\human::fitNumber($free);
		$myTitle .= " / خالی ". \dash\utility\human::fitNumber($full);
		// $myTitle .= " / تخلیه ". \dash\utility\human::fitNumber(\dash\data::mokebDetail_cleantime());

		\dash\data::page_title($myTitle);

		$full_free = \lib\app\mokebuser::full_free_name(\dash\url::child());
		\dash\data::fullFree($full_free);

		self::static_var();

		self::check_nationalcode();

		self::check_isduplicate();

		self::check_position();

		if(\dash\request::get('showname'))
		{
			\dash\data::badge_link(\dash\url::that());
			\dash\data::badge_text('نمایش جایگاه');
		}
		else
		{
			\dash\data::badge_link(\dash\url::that(). '?showname=1');
			\dash\data::badge_text('نمایش نام افراد');
		}


		if(\dash\request::get('showname'))
		{
			$full_free = \lib\app\mokebuser::full_free_name(\dash\url::child());
			\dash\data::fullFreeName($full_free);
		}

	}



	private static function check_position()
	{
		$position = \dash\request::get('position');
		if(!$position)
		{
			return;
		}

		$status = null;
		if(!is_numeric($position))
		{
			\dash\notif::error('جایگاه اشتباه است');
			$status = 'invalid';
			\dash\data::checkposition($status);
			return;
		}

		$check = \lib\db\mokebusers::get_by_position($position);
		if(isset($check['id']))
		{
			\dash\data::mokebuserDetail($check);
			$expire = \dash\data::mokebuserDetail_expire();

			if(((time() - strtotime(\dash\data::mokebuserDetail_expire()) > intval(\dash\data::mokebDetail_activetime() * 60 * 60)) || \dash\data::mokebuserDetail_forceexit()) && !\dash\data::mokebuserDetail_noposition())
			{
				$status = 'expire';
			}
			else
			{
				$status = 'signuped';
			}
		}
		else
		{
			$list = \lib\app\mokebuser::list_of_free(\dash\url::child());
			\dash\data::freePosition($list);
			$status = 'not-signuped';
		}

		if(\dash\data::mokebuserDetail_noposition())
		{
			$status = 'noposition';
		}

		\dash\data::checkNationalcode($status);
	}


	private static function check_nationalcode()
	{
		$nationalcode = \dash\request::get('cnationalcode');
		if(!$nationalcode)
		{
			return;
		}

		$status = null;
		if(!\dash\utility\filter::nationalcode($nationalcode))
		{
			\dash\notif::error('کد ملی اشتباه است');
			$status = 'invalid';
			\dash\data::checkNationalcode($status);
			return;
		}

		$check = \lib\db\mokebusers::get(['nationalcode' => $nationalcode, 'limit' => 1], ['order' => ' ORDER BY mokebusers.id DESC ']);
		if(isset($check['id']))
		{
			\dash\data::mokebuserDetail($check);
			$expire = \dash\data::mokebuserDetail_expire();

			if(((time() - strtotime(\dash\data::mokebuserDetail_expire()) > intval(\dash\data::mokebDetail_activetime() * 60 * 60)) || \dash\data::mokebuserDetail_forceexit()) && !\dash\data::mokebuserDetail_noposition())
			{
				$status = 'expire';
			}
			else
			{
				$status = 'signuped';
			}
		}
		else
		{
			$list = \lib\app\mokebuser::list_of_free(\dash\url::child());
			\dash\data::freePosition($list);
			$status = 'not-signuped';
		}

		if(\dash\data::mokebuserDetail_noposition())
		{
			$status = 'noposition';
		}

		\dash\data::nationalCity(\dash\app\nationalcode\city::get($nationalcode));
		\dash\data::checkNationalcode($status);
	}


	private static function check_isduplicate()
	{
		$nationalcode = \dash\request::get('isduplicate');
		if(!$nationalcode)
		{
			return;
		}

		$status = null;
		if(!\dash\utility\filter::nationalcode($nationalcode))
		{
			\dash\notif::error('کد ملی اشتباه است');
			$status = 'invalid';
			\dash\data::checkNationalcode($status);
			return;
		}

		$check = \lib\db\mokebusers::get(['nationalcode' => $nationalcode, 'limit' => 1], ['order' => ' ORDER BY mokebusers.id DESC ']);

		if(isset($check['id']))
		{
			\dash\data::mokebuserDetail($check);
		}
	}


	public static function static_var()
	{
		$parentList =
		[
			"father"              => T_("Father"),
			"mother"              => T_("Mother"),
			"sister"              => T_("Sister"),
			"brother"             => T_("Brother"),
			"grandfather"         => T_("Grandfather"),
			"grandmother"         => T_("Grandmother"),
			"aunt"                => T_("Aunt"),
			"husband of the aunt" => T_("Husband of the aunt"),
			"uncle"               => T_("Uncle"),
			"boy"                 => T_("Boy"),
			"girl"                => T_("Girl"),
			"spouse"              => T_("Spouse"),
			"stepmother"          => T_("Stepmother"),
			"stepfather"          => T_("Stepfather"),
			"neighbor"            => T_("Neighbor"),
			"teacher"             => T_("Teacher"),
			"friend"              => T_("Friend"),
			"boss"                => T_("Boss"),
			"supervisor"          => T_("Supervisor"),
			"child"               => T_("Child"),
			"grandson"            => T_("Grandson"),
		];
		\dash\data::parentList(implode(',' ,array_values($parentList)));

		$countryList = \dash\utility\location\countres::$data;
		\dash\data::countryList($countryList);

		// $cityList    = \dash\utility\location\cites::key_list('localname');
		// \dash\data::cityList($cityList);

		$proviceList = \dash\utility\location\provinces::key_list('localname');
		\dash\data::proviceList($proviceList);

		$countryList = \dash\utility\location\countres::$data;
		\dash\data::countryList($countryList);

		$cityList    = \dash\utility\location\cites::$data;
		$proviceList = \dash\utility\location\provinces::key_list('localname');

		$new = [];
		foreach ($cityList as $key => $value)
		{
			$temp = '';

			if(isset($value['province']) && isset($proviceList[$value['province']]))
			{
				$temp .= $proviceList[$value['province']]. ' - ';
			}
			if(isset($value['localname']))
			{
				$temp .= $value['localname'];
			}
			$new[$key] = $temp;
		}
		asort($new);

		\dash\data::cityList($new);

	}
}
?>
