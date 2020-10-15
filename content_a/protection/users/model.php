<?php
namespace content_a\protection\users;


class model
{

	public static function post()
	{
		if(\dash\data::dataRow_status() === 'draft')
		{
			// ok
		}
		else
		{
			\dash\notif::warn("وضعیت درخواست پیش‌نویس نیست و نمی‌توانید در افراد تحت پوشش تغییری ایجاد کنید");
			return false;
		}


		if(\dash\request::post('remove') === 'remove')
		{
			$post =
			[
				'occation_id'  => \dash\data::occasionID(),
				'protectagentuser_id'  => \dash\request::post('id'),
			];

			$reault = \lib\app\protectagentuser::remove($post);

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}

			return;
		}



		$post =
		[
			'occation_id'     => \dash\data::occasionID(),
			'mobile'          => \dash\request::post('mobile'),
			'displayname'     => \dash\request::post('displayname'),
			'nationalcode'    => \dash\request::post('nationalcode'),
			'city'            => \dash\request::post('city'),
			'type_id'         => \dash\request::post('type_id'),
			'gender'          => \dash\request::post('gender'),
			'married'         => \dash\request::post('married'),
			'protectioncount' => \dash\request::post('protectioncount'),
			'country'         => \dash\request::post('country'),
			'pasportcode'     => \dash\request::post('pasportcode'),
		];

		$occasion_id = \dash\data::occasionID();

		$occasionType = \lib\app\protectiontype::occasion_type($occasion_id);
		if(!is_array($occasionType))
		{
			$occasionType = [];
		}

		if($occasionType &&  !$post['type_id'])
		{
			\dash\notif::error(T_("Please choose type"), 'type');
			return false;
		}

		$file1 = \dash\app\file::upload_quick('file1');
		if($file1)
		{
			$post['file1'] = $file1;
		}


		$file2 = \dash\app\file::upload_quick('file2');
		if($file2)
		{
			$post['file2'] = $file2;
		}

		if(\dash\data::editMode())
		{
			$reault = \lib\app\protectagentuser::edit($post, \dash\request::get('person'));
			if(\dash\engine\process::status())
			{
				\dash\redirect::to(\dash\url::that(). '?id='. \dash\request::get('id'));
			}
		}
		else
		{
			$occasion_id = \dash\data::occasionID();
			$get_allow_detail_current = \lib\app\protectionagentoccasion::get_allow_detail_current($occasion_id);

			if(isset($get_allow_detail_current['capacity']) && $get_allow_detail_current['capacity'])
			{
				$count = \lib\app\protectagentuser::occasion_list_count($occasion_id);

				if($count)
				{
					if(floatval($count) >= floatval($get_allow_detail_current['capacity']))
					{
						\dash\notif::error(T_("Your capacity of inser user in this occasion is full"));
						return false;
					}
				}
			}

			$reault = \lib\app\protectagentuser::add($post);
			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}
		}
	}
}
?>
