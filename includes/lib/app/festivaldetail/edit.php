<?php
namespace lib\app\festivaldetail;

trait edit
{
	/**
	 * edit a festivaldetail
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
		if(!\dash\app::isset_request('website')) unset($args['website']);
		if(!\dash\app::isset_request('type')) unset($args['type']);
		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('logo')) unset($args['logo']);
		if(!\dash\app::isset_request('sms')) unset($args['sms']);
		if(!\dash\app::isset_request('telegram')) unset($args['telegram']);
		if(!\dash\app::isset_request('facebook')) unset($args['facebook']);
		if(!\dash\app::isset_request('twitter')) unset($args['twitter']);
		if(!\dash\app::isset_request('instagram')) unset($args['instagram']);
		if(!\dash\app::isset_request('linkedin')) unset($args['linkedin']);


		if(!empty($args))
		{
			$update = \lib\db\festivaldetails::update($args, $id);
			\dash\notif::ok(T_("Festival detail successfully updated"));

		}
	}
}
?>