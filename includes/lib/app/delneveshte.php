<?php
namespace lib\app;

class delneveshte
{

	public static $sort_field =
	[
		'id',
		'plus',
		'minus',
		'datecreated',
		'status',
		'mobile',
		'author',
		'email',
	];




	public static function list($_string = null, $_args = [])
	{

		$default_meta =
		[
			'pagenation' => true,
			'sort'       => null,
			'order'      => null,
			'join_user'  => false,
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


		$result            = \dash\db\comments::search($_string, $_args);
		$temp              = [];

		foreach ($result as $key => $value)
		{
			$check = self::ready($value);
			if($check)
			{
				$check = \dash\app::fix_avatar($check);
				$temp[] = $check;
			}
		}

		return $temp;
	}




	/**
	 * ready data of classroom to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready($_data)
	{
		$_data = \dash\app::fix_avatar($_data);
		$result = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
				case 'user_id':
				case 'parent':
				case 'term_id':
				case 'post_id':
					if(isset($value))
					{
						$result[$key] = \dash\coding::encode($value);
					}
					else
					{
						$result[$key] = null;
					}
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