<?php
namespace lib\app\product;

trait datalist
{

	public static $sort_field =
	[
		'title',
		'status',
		'subtitle',
		'price',
		'sort',
	];

	public static function all_list()
	{
		$args =
		[
			'order'      => 'asc',
			'sort'       => 'sort',
			'pagenation' => false,
		];
		$list = self::list(null, $args);
		return $list;
	}


	public static function active_list()
	{
		$args =
		[
			'order'      => 'asc',
			'sort'       => 'sort',
			'status'     => 'enable',
			'pagenation' => false,
		];
		$list = self::list(null, $args);
		return $list;
	}


	/**
	 * Gets the product.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The product.
	 */
	public static function list($_string = null, $_args = [])
	{
		if(!\dash\user::id())
		{
			return false;
		}

		$default_meta =
		[
			'sort'  => null,
			'order' => null,
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_meta, $_args);

		if($_args['sort'] && !in_array($_args['sort'], self::$sort_field))
		{
			$_args['sort'] = null;
		}

		$result            = \lib\db\product::search($_string, $_args);
		$temp              = [];

		foreach ($result as $key => $value)
		{
			$check = self::ready($value);
			if($check)
			{
				$temp[] = $check;
			}
		}

		return $temp;
	}
}
?>