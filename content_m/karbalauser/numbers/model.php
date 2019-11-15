<?php
namespace content_m\karbalauser\numbers;


class model
{
	public static function post()
	{
		\dash\permission::access('cpKarbalaUserCountAdd');


		if(\dash\request::post('type') === 'remove' && \dash\request::post('id'))
		{
			$hard_delete =
			[
				'cat' => 'stat_place_manual',
				'id'  => intval(\dash\request::post('id')),
			];
			\dash\db\options::hard_delete($hard_delete);
			\dash\notif::ok('حذف شد');
			\dash\redirect::pwd();
			return;
		}

		$city = \dash\request::post('city');
		if(!in_array($city, ['qom', 'mashhad', 'karbala']))
		{
			\dash\notif::error("لطفا شهر را انتخاب کنید");
			return false;
		}
		$status = \dash\request::post('status');
		if(!in_array($status, ['gone', 'signup']))
		{
			\dash\notif::error("لطفا وضعیت را انتخاب کنید");
			return false;
		}
		$count = \dash\request::post('count');
		$count = \dash\utility\convert::to_en_number($count);
		if(!$count || !is_numeric($count))
		{
			\dash\notif::error("لطفا تعداد افراد را وارد کنید", 'count');
			return false;
		}

		$count = intval($count);
		if($count <= 0)
		{
			\dash\notif::error("لطفا تعداد افراد را وارد کنید", 'count');
			return false;
		}

		$desc = \dash\request::post('desc');
		if(!$desc)
		{
			\dash\notif::warn("بهتر است توضیحات را برای مدیریت یادداشت خودتان وارد کنید", 'desc');
		}

		$new_record =
		[
			'city'   => $city,
			'status' => $status,
			'count'  => $count,
			'desc'   => $desc,
		];

		$new_option_record =
		[
			'cat'   => 'stat_place_manual',
			'key'   => null,
			'value' => $count,
			'meta'  => json_encode($new_record, JSON_UNESCAPED_UNICODE),
		];

		\dash\db\options::insert($new_option_record);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Data saved"));
		}

		\dash\redirect::pwd();

	}
}
?>
