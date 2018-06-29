<?php
namespace lib\app\festival;

trait add
{

	/**
	 * add new festival
	 *
	 * @param      array          $_args  The arguments
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public static function add($_args = [])
	{
		// not remvoe html tag and single or dbl qute from this field
		// because get from editor
		$raw_field =
		[
			'desc',
			'intro',
			'about',
			'target',
			'axis',
			'view',
			'schedule',
			'logo',
			'gallery',
			'place',
			'award',
			'phone',
			'address',
			'email',
			'poster',
			'brochure',
			'message',
			'messagesms'
		];

		\dash\app::variable($_args, ['raw_field' => $raw_field]);

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
			$args['status']  = 'draft';
		}
		$args['creator']  = \dash\user::id();

		$args = array_filter($args);

		$festival_id = \lib\db\festivals::insert($args);

		if(!$festival_id)
		{
			\dash\notif::error(T_("No way to insert festival"), 'db');
			return false;
		}

		$return['id'] = \dash\coding::encode($festival_id);

		if(\dash\engine\process::status())
		{
			\dash\notif::ok(T_("Festival successfuly added"));
		}

		return $return;
	}

}
?>