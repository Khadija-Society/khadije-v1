<?php
namespace lib\app;

/**
 * Class for festivaldetail.
 */
class festivaldetail
{

	use festivaldetail\add;
	use festivaldetail\edit;
	use festivaldetail\datalist;


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("Festival id not set"));
			return false;
		}


		$get = \lib\db\festivaldetails::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid festivaldetail id"));
			return false;
		}

		$result = self::ready($get);

		return $result;
	}


	/**
	 * check args
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	private static function check($_id = null)
	{
		$festival_id = \dash\app::request('festival_id');
		$festival_id = \dash\coding::decode($festival_id);
		if(!$festival_id)
		{
			\dash\notif::error(T_("Invalid festival id"));
			return false;
		}

		$title = \dash\app::request('title');
		if(!$title && \dash\app::isset_request('title'))
		{
			\dash\notif::error(T_("Please fill festival detail title"), 'title');
			return false;
		}

		if($title && mb_strlen($title) > 500)
		{
			\dash\notif::error(T_("Please fill festival detail title less than 500 character"), 'title');
			return false;
		}

		if($title)
		{
			$check_duplicate = \lib\db\festivaldetails::get(['festival_id' => $festival_id, 'title' => $title, 'limit' => 1]);

			if(isset($check_duplicate['id']))
			{
				if(intval($_id) === intval($check_duplicate['id']))
				{
					// no problem to edit it
				}
				else
				{
					\dash\notif::error(T_("Duplicate festivaldetail title"), 'title');
					return false;
				}
			}
		}

		$status = \dash\app::request('status');
		if($status && !in_array($status, ['draft','awaiting','enable','expire','cancel', 'deleted', 'disable']))
		{
			\dash\notif::error(T_("Invalid status of festivaldetail"), 'status');
			return false;
		}

		$subtitle = \dash\app::request('subtitle');
		if($subtitle && mb_strlen($subtitle) > 500)
		{
			\dash\notif::error(T_("Please fill festival detail subtitle less than 500 character"), 'subtitle');
			return false;
		}

		$website = \dash\app::request('website');
		if($website && mb_strlen($website) > 500)
		{
			\dash\notif::error(T_("Please fill festival detail website less than 500 character"), 'website');
			return false;
		}

		$type = \dash\app::request('type');
		if($type && mb_strlen($type) > 100)
		{
			\dash\notif::error(T_("Please fill festival detail type less than 500 character"), 'type');
			return false;
		}

		$desc = \dash\app::request('desc');
		$logo = \dash\app::request('logo');

		$sms = \dash\app::request('sms');
		if($sms && mb_strlen($sms) > 500)
		{
			\dash\notif::error(T_("Please fill festival detail sms less than 500 character"), 'sms');
			return false;
		}

		$telegram = \dash\app::request('telegram');
		if($telegram && mb_strlen($telegram) > 500)
		{
			\dash\notif::error(T_("Please fill festival detail telegram less than 500 character"), 'telegram');
			return false;
		}

		$facebook = \dash\app::request('facebook');
		if($facebook && mb_strlen($facebook) > 500)
		{
			\dash\notif::error(T_("Please fill festival detail facebook less than 500 character"), 'facebook');
			return false;
		}

		$twitter = \dash\app::request('twitter');
		if($twitter && mb_strlen($twitter) > 500)
		{
			\dash\notif::error(T_("Please fill festival detail twitter less than 500 character"), 'twitter');
			return false;
		}

		$instagram = \dash\app::request('instagram');
		if($instagram && mb_strlen($instagram) > 500)
		{
			\dash\notif::error(T_("Please fill festival detail instagram less than 500 character"), 'instagram');
			return false;
		}

		$linkedin = \dash\app::request('linkedin');
		if($linkedin && mb_strlen($linkedin) > 500)
		{
			\dash\notif::error(T_("Please fill festival detail linkedin less than 500 character"), 'linkedin');
			return false;
		}

		$args                = [];
		$args['festival_id'] = $festival_id;
		$args['title']       = $title;
		$args['status']      = $status;
		$args['subtitle']    = $subtitle;
		$args['website']     = $website;
		$args['type']        = $type;
		$args['desc']        = $desc;
		$args['logo']        = $logo;
		$args['sms']         = $sms;
		$args['telegram']    = $telegram;
		$args['facebook']    = $facebook;
		$args['twitter']     = $twitter;
		$args['instagram']   = $instagram;
		$args['linkedin']    = $linkedin;

		return $args;
	}


	/**
	 * ready data of festivaldetail to load in api
	 *
	 * @param      <type>  $_data  The data
	 */
	public static function ready($_data)
	{
		$result = [];
		foreach ($_data as $key => $value)
		{

			switch ($key)
			{
				case 'id':
				case 'creator':
				case 'festival_id':
					$result[$key] = \dash\coding::encode($value);
					break;

				default:
					$result[$key] = $value;
					break;
			}
		}

		return $result;
	}

}
?>