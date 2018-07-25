<?php
namespace lib\app;

/**
 * Class for festivalcourse.
 */
class festivalcourse
{

	use festivalcourse\add;
	use festivalcourse\edit;
	use festivalcourse\datalist;


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("Festival id not set"));
			return false;
		}


		$get = \lib\db\festivalcourses::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid festivalcourse id"));
			return false;
		}

		$result = self::ready($get);

		return $result;
	}


	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_id = null)
	{
		$festival_id = \dash\app::request('festival_id');
		$festival_id = \dash\coding::decode($festival_id);
		if(!$festival_id)
		{
			\dash\notif::error(T_("Invalid festival id"));
			return false;
		}

		$title = \dash\app::request('title');
		if(!$title && \dash\app::isset_request('title'))
		{
			\dash\notif::error(T_("Please fill course title"), 'title');
			return false;
		}

		if($title && mb_strlen($title) > 500)
		{
			\dash\notif::error(T_("Please fill course title less than 500 character"), 'title');
			return false;
		}

		if($title)
		{
			$check_duplicate = \lib\db\festivalcourses::get(['festival_id' => $festival_id, 'title' => $title, 'limit' => 1]);

			if(isset($check_duplicate['id']))
			{
				if(intval($_id) === intval($check_duplicate['id']))
				{
					// no problem to edit it
				}
				else
				{
					\dash\notif::error(T_("Duplicate festivalcourse title"), 'title');
					return false;
				}
			}
		}

		$status = \dash\app::request('status');
		if($status && !in_array($status, ['draft','awaiting','enable','expire','cancel', 'deleted', 'disable']))
		{
			\dash\notif::error(T_("Invalid status of festivalcourse"), 'status');
			return false;
		}

		$subtitle = \dash\app::request('subtitle');
		if($subtitle && mb_strlen($subtitle) > 500)
		{
			\dash\notif::error(T_("Please fill course subtitle less than 500 character"), 'subtitle');
			return false;
		}

		$group = \dash\app::request('group');
		if($group && mb_strlen($group) > 500)
		{
			\dash\notif::error(T_("Please fill course group less than 500 character"), 'group');
			return false;
		}

		$condition = \dash\app::request('condition');
		$conditionsend = \dash\app::request('conditionsend');
		$desc = \dash\app::request('desc');

		$price = \dash\app::request('price');
		if($price && !is_numeric($price))
		{
			\dash\notif::error(T_("Please fill course price as a number"), 'price');
			return false;
		}

		if($price && intval($price) > 1E+9)
		{
			$price = intval(1E+9);
		}

		$allowfile = \dash\app::request('allowfile');
		$multiuse  = \dash\app::request('multiuse') ? 1 : null;
		$score     = \dash\app::request('score');
		$link      = \dash\app::request('link');


		$args                  = [];
		$args['festival_id']   = $festival_id;
		$args['title']         = $title;
		$args['status']        = $status;
		$args['subtitle']      = $subtitle;
		$args['group']         = $group;
		$args['condition']     = $condition;
		$args['conditionsend'] = $conditionsend;
		$args['desc']          = $desc;
		$args['price']         = $price;
		$args['allowfile']     = $allowfile;
		$args['multiuse']      = $multiuse;
		$args['score']         = $score;
		$args['link']          = $link;

		return $args;
	}


	/**
	 * ready data of festivalcourse to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready($_data)
	{
		$result = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
				case 'creator':
				case 'festival_id':
					$result[$key] = \dash\coding::encode($value);
					break;

				default:
					$result[$key] = $value;
					break;
			}
		}

		return $result;
	}

}
?>