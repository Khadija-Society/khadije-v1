<?php
namespace lib\app\festivalcourse;

trait datalist
{

	public static $sort_field =
	[
		'title',
		'slug',
		'status',
		'datecreated',
	];

	/**
	 * Gets the festivalcourse.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The festivalcourse.
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


		$result            = \lib\db\festivalcourses::search($_string, $_args);
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