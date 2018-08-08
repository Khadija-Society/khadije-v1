<?php
namespace content_cp\festival\transaction;


class view
{
	public static function config()
	{
		\dash\permission::access('cpFesitvalTransaction');

		\dash\data::page_title(T_("Festival transaction"));
		\dash\data::page_desc(T_("check festival last transactions and monitor them"));
		\dash\data::page_pictogram('magic');

		\dash\data::badge_link(\dash\url::this(). '?id='. \dash\request::get('id'));
		\dash\data::badge_text(T_('Back to dashboard'));

		\dash\data::bodyclass('unselectable');
		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		$args =
		[
			'order'          => \dash\request::get('order'),
			'sort'           => \dash\request::get('sort'),
		];
		$transaction_args = [];

		if(!$args['order'])
		{
			$args['order'] = 'DESC';
		}

		if(!$args['sort'])
		{
			$args['sort'] = 'dateverify';
		}

		if(\dash\request::get('payment'))
		{
			$args['payment'] = \dash\request::get('payment');
			$transaction_args['payment'] = $args['payment'];
		}

		if(\dash\request::get('mobile'))
		{
			$args['mobile'] = \dash\request::get('mobile');
			$user_id = \dash\db\users::get_by_mobile($args['mobile']);
			if(isset($user_id['id']))
			{
				$transaction_args['user_id'] = $user_id['id'];
			}
		}


		if(\dash\request::get('course'))
		{
			$args['niyat'] = \dash\request::get('course');
			$transaction_args['niyat'] = $args['niyat'];
		}

		$args['donate']                 = 'festival';
		$transaction_args['donate']     = $args['donate'];
		$args['condition']              = 'ok';
		$transaction_args['condition']  = $args['condition'];
		$args['hazinekard']             = \dash\coding::decode(\dash\request::get('id'));
		$transaction_args['hazinekard'] = $args['hazinekard'];
		$search_string      = \dash\request::get('q');

		if($search_string)
		{
			\dash\data::page_title(T_('Search'). ' '.  $search_string);
		}

		$dataTable = \dash\app\transaction::list($search_string, $args);

		\dash\data::sortLink(\content_cp\view::make_sort_link(\dash\app\transaction::$sort_field, \dash\url::this(). '/transaction'));

		if(is_array($dataTable))
		{
			$course_id = array_column($dataTable, 'niyat');
			$course_id = array_filter($course_id);
			$course_id = array_unique($course_id);
			$course_id = implode(',', $course_id);
			$course_list = \lib\db\festivalcourses::get(['id' => ["IN", "($course_id)"]]);
			$id = array_column($course_list, 'id');
			$course_list = array_combine($id, $course_list);
			foreach ($dataTable as $key => $value)
			{
				if(isset($value['niyat']))
				{
					if(array_key_exists($value['niyat'], $course_list))
					{
						if(isset($course_list[$value['niyat']]['title']))
						{
							$dataTable[$key]['course_title'] = $course_list[$value['niyat']]['title'];
						}
					}
				}
			}

		}
		\dash\data::dataTable($dataTable);

		if(\dash\permission::check('cpDonateTotalPay'))
		{
			\dash\data::totalPaid(\lib\db\mytransactions::total_paid($transaction_args));
			\dash\data::totalPaidDate(\lib\db\mytransactions::total_paid($transaction_args, true));
			\dash\data::totalPaidCount(\lib\db\mytransactions::total_paid($transaction_args, false, true));
		}

		$filterArray = $args;
		unset($filterArray['donate']);
		unset($filterArray['condition']);
		unset($filterArray['hazinekard']);
		if(isset($filterArray['niyat']))
		{
			$filterArray[T_("Festival course")] = isset($course_list[$filterArray['niyat']]['title']) ? $course_list[$filterArray['niyat']]['title'] : $filterArray['niyat'];
			unset($filterArray['niyat']);
		}

		// set dataFilter
		$dataFilter = \dash\app\sort::createFilterMsg($search_string, $filterArray);
		\dash\data::dataFilter($dataFilter);

	}
}
?>
