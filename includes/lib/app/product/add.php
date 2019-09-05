<?php
namespace lib\app\product;

trait add
{

	/**
	 * add new product
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

		$product_id = \lib\db\product::insert($args);

		if(!$product_id)
		{
			\dash\log::set('apiProduct:no:way:to:insertProduct');
			\dash\notif::error(T_("No way to insert product"), 'db', 'system');
			return false;
		}

		$return['id'] = \dash\coding::encode($product_id);

		if(\dash\engine\process::status())
		{
			\dash\log::set('addNewProduct', ['code' => $product_id]);
			\dash\notif::ok(T_("Product successfuly added"));
		}

		return $return;
	}

}
?>