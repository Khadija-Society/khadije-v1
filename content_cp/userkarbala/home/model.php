<?php
namespace content_cp\userkarbala\home;

class model
{

	public static function post()
	{
		if(\dash\permission::check('exportKarbalaUsers') && \dash\request::post('export'))
		{
			$addr = __DIR__. '/export_request.me.text';
			if(!is_file($addr))
			{
				$datetime = date("Y-m-d H:i:s");

				\dash\file::write($addr, $datetime);

				self::_curl(['datetime' => $datetime]);

				\dash\notif::ok("درخواست خروجی صادر شد. تا دقایقی دیگر فایل خروجی برای دانلود آماده خواهد شد <br> پایان فرایند از طریق بخش اطلاع رسانی به شما اعلام خواهد شد");
				return true;
			}
			else
			{
				\dash\notif::warn("فرایند تهیه خروجی از لیست زائران کربلا در حال انجام است. <br> پایان فرایند از طریق بخش اطلاع رسانی به شما اعلام خواهد شد");
				return false;
			}
		}

	}

	public static function verify()
	{
		if(\dash\request::post('datetime'))
		{
			$addr = __DIR__. '/export_request.me.text';
			$saved = \dash\file::read($addr);
			if(\dash\request::post('datetime') === $saved)
			{
				self::export_list();
			}
			else
			{
				\dash\log::set('invalidExportCurl');
			}
		}
	}


	public static function export_list()
	{

		// set_time_limit(60 * 10);
		// ini_set('memory_limit', '-1');
		// ini_set("max_execution_time", "-1");

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

		$addr = __DIR__. '/export_request.me.text';
		\dash\file::delete($addr);


		\dash\log::set('karbalaUsersExportCsvFile', ['fileaddr' => $link]);

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


	public static function _curl($_requests)
	{
		$handle   = curl_init();
		curl_setopt($handle, CURLOPT_URL, \dash\url::kingdom().'/a/exportcurlkarbalausers');
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_POST, true);

		curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($_requests));
		curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($handle, CURLOPT_TIMEOUT, 5);

		if(defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4'))
		{
 			curl_setopt($handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		}

		$response = curl_exec($handle);
		curl_close ($handle);
	}
}
?>