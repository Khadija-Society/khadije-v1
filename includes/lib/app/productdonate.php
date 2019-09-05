<?php
namespace lib\app;

class productdonate
{

	public static $sort_field =
	[
		'title',
		'status',
		'subtitle',
		'price',
		'sort',
	];

	public static function active_list()
	{
		$args =
		[
			'order'  => 'asc',
			'sort'   => 'sort',
			'status' => 'enable',
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

		$result            = \lib\db\productdonate::search($_string, $_args);
		$temp              = [];

		foreach ($result as $key => $value)
		{
			$check = \dash\app::fix_avatar($value);
			$check = self::ready($value);
			if($check)
			{
				$temp[] = $check;
			}
		}


		return $temp;
	}

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

				case 'file':
					if(!\dash\url::content())
					{
						if(!$value)
						{
							$value = \dash\app::static_logo_url();
						}
					}
					$result[$key] = $value;
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