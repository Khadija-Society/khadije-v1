<?php
namespace lib\app\festival;

trait datalist
{

	public static $sort_field =
	[
		'title',
		'status',
		'signup',
	];


	public static function active_list($_implode = false, $_retrun_all = false)
	{
		$result = \lib\db\festivals::get(['academy_id' => \lib\academy::query_id(), 'status' => 'enable']);
		if(is_array($result))
		{
			if(!$_retrun_all)
			{
				$result = array_column($result, 'title');
			}
		}

		if($_implode)
		{
			$result = implode(',', $result);
		}

		return $result;
	}

	/**
	 * Gets the festival.
	 *
	 * @param      <type>  $_args  The arguments
	 *
	 * @return     <type>  The festival.
	 */
	public static function list($_string = null, $_args = [])
	{
		if(!\dash\user::id() || !\lib\academy::id())
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


		$_args['academy_id'] = \lib\academy::query_id();

		$result            = \lib\db\festivals::search($_string, $_args);
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