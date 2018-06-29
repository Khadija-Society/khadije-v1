<?php
namespace lib\app\festival;

trait edit
{
	/**
	 * edit a festival
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function edit($_args, $_id)
	{
		\dash\app::variable($_args);

		$result = self::get($_id);

		if(!$result)
		{
			return false;
		}

		$id = \dash\coding::decode($_id);

		$args = self::check($id);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}


		if(!empty($args))
		{
			$update = \lib\db\festivals::update($args, $id);

			\lib\db\festivals::refresh($id);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
			// remove cash of cat list
			self::dashboard(true);

		}
	}
}
?>