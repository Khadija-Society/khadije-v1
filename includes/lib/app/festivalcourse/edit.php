<?php
namespace lib\app\festivalcourse;

trait edit
{
	/**
	 * edit a festivalcourse
	 *
	 * @param      <type>   $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public static function edit($_args, $_id)
	{
		\dash\app::variable($_args, ['raw_field' => self::$raw_field]);

		$id = \dash\coding::decode($_id);

		if(!$id)
		{
			return false;
		}

		$args = self::check($id);

		if($args === false || !\dash\engine\process::status())
		{
			return false;
		}

		if(!\dash\app::isset_request('festival_id')) unset($args['festival_id']);
		if(!\dash\app::isset_request('title')) unset($args['title']);
		if(!\dash\app::isset_request('status')) unset($args['status']);
		if(!\dash\app::isset_request('subtitle')) unset($args['subtitle']);
		if(!\dash\app::isset_request('group')) unset($args['group']);
		if(!\dash\app::isset_request('condition')) unset($args['condition']);
		if(!\dash\app::isset_request('conditionsend')) unset($args['conditionsend']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('price')) unset($args['price']);
		if(!\dash\app::isset_request('allowfile')) unset($args['allowfile']);
		if(!\dash\app::isset_request('multiuse')) unset($args['multiuse']);
		if(!\dash\app::isset_request('score')) unset($args['score']);
		if(!\dash\app::isset_request('link')) unset($args['link']);
		if(!\dash\app::isset_request('file')) unset($args['file']);

		if(!empty($args))
		{
			$update = \lib\db\festivalcourses::update($args, $id);
			\dash\notif::ok(T_("Course successfully updated"));

		}
	}
}
?>