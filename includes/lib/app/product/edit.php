<?php
namespace lib\app\product;

trait edit
{
	/**
	 * edit a product
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

		if(!\dash\app::isset_request('title')) unset($args['title']);
		if(!\dash\app::isset_request('status')) unset($args['status']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('signup')) unset($args['signup']);
		if(!\dash\app::isset_request('sort')) unset($args['sort']);
		if(!\dash\app::isset_request('subtitle')) unset($args['subtitle']);
		if(!\dash\app::isset_request('file')) unset($args['file']);
		if(!\dash\app::isset_request('price')) unset($args['price']);

		if(!empty($args))
		{
			$update = \lib\db\product::update($args, $id);
			\dash\log::set('editGrade', ['code' => $id]);

			$title = isset($args['title']) ? $args['title'] : T_("Data");
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_(":title successfully updated", ['title' => $title]));
			}
		}
	}
}
?>