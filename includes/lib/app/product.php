<?php
namespace lib\app;

/**
 * Class for product.
 */
class product
{

	use product\add;
	use product\edit;
	use product\datalist;


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("product id not set"));
			return false;
		}

		$get = \lib\db\product::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid product id"));
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
		$title = \dash\app::request('title');
		$title = trim($title);
		if(!$title)
		{
			\dash\notif::error(T_("Please fill the product title"), 'title');
			return false;
		}

		if(mb_strlen($title) > 150)
		{
			\dash\notif::error(T_("Please fill the product title less than 150 character"), 'title');
			return false;
		}

		$check_duplicate = \lib\db\product::get(['title' => $title, 'limit' => 1]);
		if(isset($check_duplicate['id']))
		{
			if(intval($_id) === intval($check_duplicate['id']))
			{
				// no problem to edit it
			}
			else
			{
				\dash\notif::error(T_("Duplicate product title"), 'title');
				return false;
			}
		}


		$status = \dash\app::request('status');
		if($status && !in_array($status, ['enable', 'disable']))
		{
			\dash\notif::error(T_("Invalid status of product"), 'status');
			return false;
		}

		$sort = \dash\app::request('sort');
		if($sort && !is_numeric($sort))
		{
			\dash\notif::error(T_("Please set sort as a number"), 'sort');
			return false;
		}

		if($sort)
		{
			$sort = abs(intval($sort));
		}

		if($sort && $sort > 9999)
		{
			\dash\notif::error(T_("Sort is out of range"), 'sort');
			return false;
		}

		$desc = \dash\app::request('desc');
		$desc = trim($desc);
		if($desc && mb_strlen($desc) > 500)
		{
			\dash\notif::error(T_("Description must be less than 500 character"), 'desc');
			return false;
		}


		$subtitle = \dash\app::request('subtitle');

		if($subtitle && mb_strlen($subtitle) > 150)
		{
			\dash\notif::error(T_("Please fill the product subtitle less than 150 character"), 'subtitle');
			return false;
		}

		$file = \dash\app::request('file');

		$price = \dash\app::request('price');
		if($price && !is_numeric($price))
		{
			\dash\notif::error(T_("Please set price as a number"), 'price');
			return false;
		}

		if($price)
		{
			$price = abs(intval($price));
		}

		if($price && $price > 999999999)
		{
			\dash\notif::error(T_("Price is out of range"), 'price');
			return false;
		}


		$args             = [];
		$args['title']    = $title;
		$args['status']   = $status;
		$args['desc']     = $desc;
		$args['sort']     = $sort;
		$args['subtitle'] = $subtitle;
		$args['file']     = $file;
		$args['price']    = $price;

		return $args;
	}


	/**
	 * ready data of product to load in api
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