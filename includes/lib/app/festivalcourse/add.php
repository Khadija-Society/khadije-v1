<?php
namespace lib\app\festivalcourse;

trait add
{
	// not remvoe html tag and single or dbl qute from this field
	// because get from editor
	public static $raw_field =
	[

		'link',
		'allowfile',
		'condition',
		'conditionsend',

	];

	/**
	 * add new festivalcourse
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args = [])
	{
		$raw_field =

		\dash\app::variable($_args, ['raw_field' => self::$raw_field]);

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("User not found"), 'user');
			return false;
		}

		// check args
		$args = self::check();

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		$return = [];

		if(!$args['status'])
		{
			$args['status']  = 'enable';
		}

		$args['creator']  = \dash\user::id();

		$args = array_filter($args);

		$festivalcourse_id = \lib\db\festivalcourses::insert($args);

		if(!$festivalcourse_id)
		{
			\dash\notif::error(T_("No way to insert festivalcourse"), 'db');
			return false;
		}

		$return['id'] = \dash\coding::encode($festivalcourse_id);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Festival successfuly added"));
		}

		return $return;
	}

}
?>