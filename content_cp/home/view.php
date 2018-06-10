<?php
namespace content_cp\home;

class view
{
	public static function config()
	{
		if(\dash\request::get('fixAllDate') === 'yes')
		{
			self::fixAllDate();
			\dash\code::exit();
		}

		\dash\permission::access('contentCp');
		\dash\data::page_pictogram('gauge');


		\dash\data::include_adminPanel(true);
		\dash\data::include_css(false);

		\dash\data::display_cp_posts("content_cp/posts/layout.html");
		\dash\data::display_cpSample("content_cp/sample/layout.html");


		\dash\data::dash_version(\dash\engine\version::get());
		\dash\data::dash_lastUpdate(\dash\utility\git::getLastUpdate());

		\dash\data::page_title(T_(ucfirst( str_replace('/', ' ', \dash\url::directory()))));

		if(!\dash\data::page_title())
		{
			\dash\data::page_title(T_("Khadije Dashboard"));
		}
		\dash\data::page_desc(T_("Khadije Dashboard"));

		// $this->data->dir['right']     = $this->global->direction == 'rtl'? 'left':  'right';
		// $this->data->dir['left']      = $this->global->direction == 'rtl'? 'right': 'left';
	}

	private static function fixAllDate()
	{
		echo '<h1>FIX ALL DATE FROM JALALI TO GREGORIAN</h1>';
		$list = \dash\db::get("SELECT services.id, services.startdate, services.enddate from services");
		foreach ($list as $key => $value)
		{
			$startdate = $value['startdate'];
			$enddate   = $value['enddate'];

			if($startdate)
			{
				$startdate = \dash\date::force_gregorian($startdate);
			}

			if($enddate)
			{
				$enddate = \dash\date::force_gregorian($enddate);
			}

			if($startdate || $enddate)
			{
				$q = [];
				if($startdate)
				{
					$q[] = " services.startdate = '$startdate' ";
				}

				if($enddate)
				{
					$q[] = " services.enddate = '$enddate' ";
				}

				if(!empty($q))
				{
					$q = implode(',', $q);
					\dash\db::query("UPDATE services SET $q WHERE services.id = $value[id] LIMIT 1");
				}
			}
		}

		echo '<h1>FIX ALL CITY, PROVINCE AND COUNTRY FROM USERS</h1>';
		$city = \dash\db::get("SELECT users.city as `city` from users GROUP BY users.city", 'city');
		$city = array_unique($city);
		foreach ($city as $key => $value)
		{
			if(!$value)
			{
				continue;
			}
			$get_key = \dash\utility\location\cites::get_key($value);
			if(!$get_key)
			{
				continue;
			}

			\dash\db::query("UPDATE users SET users.city = '$get_key' WHERE users.city = '$value' ");
		}

		$province = \dash\db::get("SELECT users.province as `province` from users GROUP BY users.province", 'province');
		$province = array_unique($province);
		foreach ($province as $key => $value)
		{
			if(!$value)
			{
				continue;
			}
			$get_key = \dash\utility\location\provinces::get_key($value);
			if(!$get_key)
			{
				continue;
			}

			\dash\db::query("UPDATE users SET users.province = '$get_key' WHERE users.province = '$value' ");
		}


		$country = \dash\db::get("SELECT users.country as `country` from users GROUP BY users.country", 'country', 'count');
		$country = array_unique($country);
		foreach ($country as $key => $value)
		{
			if(!$value)
			{
				continue;
			}

			if(
				strpos($value, 'iran') !== false ||
				strpos($value, 'Iran') !== false ||
				strpos($value, 'ایران') !== false ||
				strpos($value, '1یران') !== false ||
				strpos($value, 'اایران') !== false ||
				strpos($value, 'اسلام') !== false ||
				strpos($value, 'ایرا') !== false ||
				strpos($value, 'ایران اسلامی') !== false ||
				strpos($value, 'ایران قم 02538612800') !== false ||
				strpos($value, 'ایرانی') !== false ||
				strpos($value, 'ایرن') !== false ||
				strpos($value, 'ایزان') !== false ||
				strpos($value, 'تهران') !== false ||
				strpos($value, 'خراسان رضوی') !== false ||
				strpos($value, 'غیران') !== false ||
				strpos($value, 'قم') !== false ||
				strpos($value, 'ايران') !== false ||
				strpos($value, 'مشهد') !== false

			  )
			{
				\dash\db::query("UPDATE users SET users.country = 'iran' WHERE users.country = '$value' ");
			}

			if(
				strpos($value, 'iraq') !== false ||
				strpos($value, 'Iraq') !== false ||
				strpos($value, 'عراق') !== false ||
				strpos($value, 'کربلا') !== false
			  )
			{
				\dash\db::query("UPDATE users SET users.country = 'iraq' WHERE users.country = '$value' ");
			}


			if(
				strpos($value, 'iraq') !== false ||
				strpos($value, 'afghanistan - ‫افغانستان') !== false ||
				strpos($value, 'افقانستان') !== false ||
				strpos($value, 'افغانستان') !== false
			  )
			{
				\dash\db::query("UPDATE users SET users.country = 'afghanistan' WHERE users.country = '$value' ");
			}

			if(

				strpos($value, 'پاکستا ن  زینبیون  روحانی  مدافع  حرم ') !== false ||
				strpos($value, 'پاکستان') !== false
			  )
			{
				\dash\db::query("UPDATE users SET users.country = 'pakistan' WHERE users.country = '$value' ");
			}
		}
	}
}
?>
