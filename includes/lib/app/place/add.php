<?php
namespace lib\app\place;

trait add
{

	/**
	 * add new place
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args = [])
	{
		\dash\app::variable($_args);

		if(!\dash\user::id())
		{
			\dash\notif::error(T_("user not found"), 'user');
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

		$place_id = \lib\db\place::insert($args);

		if(!$place_id)
		{
			\dash\log::set('apiPlace:no:way:to:insertPlace');
			\dash\notif::error(T_("No way to insert place"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($place_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewPlace', ['code' => $place_id]);
			\dash\notif::ok(T_("Place successfuly added"));
		}

		return $return;
	}

}
?>