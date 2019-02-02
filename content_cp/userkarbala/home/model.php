<?php
namespace content_cp\userkarbala\home;

class model
{

	public static function post()
	{

		if(\dash\permission::check('exportKarbalaUsers') && \dash\request::post('export'))
		{
			self::export_list();
			return;
		}

	}


	private static function export_list()
	{

		\dash\log::set('karbalaUsersExportCsvFile');
		set_time_limit(60 * 10);
		ini_set('memory_limit', '-1');
		ini_set("max_execution_time", "-1");

		$_args               = [];
		$_args['pagenation'] = false;
		$_args['limit']      = 1000;
		$my_limit            = 1000;
		$link                = null;
		$result              = \lib\db\karbalausers::search(null, $_args);
		while ($result)
		{
			$result = array_map(["\\lib\\app\\karbalauser", "ready"], $result);
			$link = self::csv($result);
			$_args['start_limit'] = $my_limit;
			$_args['end_limit']   = 1000;
			$result               = \lib\db\karbalausers::search(null, $_args);
			$my_limit             = $my_limit + 1000;
		}

		$msg = T_("Create export file completed");
		$msg .= '<a href="'. $link. '" download > <b>'. T_("To download it click here"). '</b> </a>';
		$msg .= '<br>'. T_("This file will be automatically deleted for a few minutes");
		\dash\notif::ok($msg, ['timeout' => 999999]);
		return true;

	}

	private static function csv($_data)
	{
		if(!is_array($_data))
		{
			return false;
		}

		$result = [];
		foreach ($_data as $key => $value)
		{
			$temp                           = [];
			$temp[T_('id')]                 = $value['id'];
			$temp[T_('mobile')]             = $value['mobile'];
			$temp[T_('firstname')]          = $value['firstname'];
			$temp[T_('lastname')]           = $value['lastname'];
			$temp[T_('Nationalcode')]       = $value['nationalcode'];
			$temp[T_('Father')]             = $value['father'];
			$temp[T_('gender')]             = T_($value['gender']);
			$temp[T_('married')]            = T_($value['married']);
			$temp[T_('birthday')]           = \dash\datetime::fit($value['birthday'], false, 'date');
			// $temp[T_('province')]        = $value['province'];
			$temp[T_('Province')]           = $value['province_name'];
			$temp[T_('City')]               = $value['city_name'];
			// $temp[T_('location_string')] = $value['location_string'];
			$temp[T_('Address')]            = $value['homeaddress'];
			$temp[T_('phone')]              = $value['phone'];
			$temp[T_('datecreated')]        = \dash\datetime::fit($value['datecreated'], 'shortDate', 'datetime');
			$result[]                       = $temp;

		}
		return \dash\utility\export::csv_file(['name' => 'export_member', 'data' => $result]);
	}
}
?>