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

		if(!\dash\app::isset_request('desc')) unset($args['desc']);
		if(!\dash\app::isset_request('intro')) unset($args['intro']);
		if(!\dash\app::isset_request('about')) unset($args['about']);
		if(!\dash\app::isset_request('target')) unset($args['target']);
		if(!\dash\app::isset_request('axis')) unset($args['axis']);
		if(!\dash\app::isset_request('view')) unset($args['view']);
		if(!\dash\app::isset_request('schedule')) unset($args['schedule']);
		if(!\dash\app::isset_request('logo')) unset($args['logo']);
		if(!\dash\app::isset_request('gallery')) unset($args['gallery']);
		if(!\dash\app::isset_request('place')) unset($args['place']);
		if(!\dash\app::isset_request('award')) unset($args['award']);
		if(!\dash\app::isset_request('phone')) unset($args['phone']);
		if(!\dash\app::isset_request('address')) unset($args['address']);
		if(!\dash\app::isset_request('email')) unset($args['email']);
		if(!\dash\app::isset_request('poster')) unset($args['poster']);
		if(!\dash\app::isset_request('brochure')) unset($args['brochure']);
		if(!\dash\app::isset_request('message')) unset($args['message']);
		if(!\dash\app::isset_request('messagesms')) unset($args['messagesms']);
		if(!\dash\app::isset_request('title')) unset($args['title']);
		if(!\dash\app::isset_request('status')) unset($args['status']);
		if(!\dash\app::isset_request('freeuser')) unset($args['freeuser']);
		if(!\dash\app::isset_request('subtitle')) unset($args['subtitle']);
		if(!\dash\app::isset_request('slug')) unset($args['slug']);
		if(!\dash\app::isset_request('sms')) unset($args['sms']);
		if(!\dash\app::isset_request('telegram')) unset($args['telegram']);
		if(!\dash\app::isset_request('facebook')) unset($args['facebook']);
		if(!\dash\app::isset_request('twitter')) unset($args['twitter']);
		if(!\dash\app::isset_request('instagram')) unset($args['instagram']);
		if(!\dash\app::isset_request('linkedin')) unset($args['linkedin']);
		if(!\dash\app::isset_request('website')) unset($args['website']);
		if(!\dash\app::isset_request('language')) unset($args['language']);


		if(!empty($args))
		{
			$update = \lib\db\festivals::update($args, $id);
			\dash\notif::ok(T_("Festival successfully updated"));

		}
	}
}
?>