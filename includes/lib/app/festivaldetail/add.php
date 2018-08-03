<?php
namespace lib\app\festivaldetail;

trait add
{
	// not remvoe html tag and single or dbl qute from this field
	// because get from editor
	public static $raw_field =
	[
		'website',

	];

	/**
	 * add new festivaldetail
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

		$festivaldetail_id = \lib\db\festivaldetails::insert($args);

		if(!$festivaldetail_id)
		{
			\dash\notif::error(T_("No way to insert festivaldetail"), 'db');
			return false;
		}

		$return['id'] = \dash\coding::encode($festivaldetail_id);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Festival successfuly added"));
		}

		return $return;
	}

}
?>