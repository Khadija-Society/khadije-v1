<?php
namespace lib\app;

/**
 * Class for festival.
 */
class festival
{

	use festival\add;
	use festival\edit;
	use festival\datalist;


	public static function festival_gallery($_festival_id, $_file_index, $_type = 'add')
	{
		$festival_id = \dash\coding::decode($_festival_id);
		if(!$festival_id)
		{
			\dash\notif::error(T_("Invalid festival id"));
			return false;
		}

		$load_festival_gallery = \lib\db\festivals::get(['id' => $festival_id, 'limit' => 1]);

		if(!array_key_exists('gallery', $load_festival_gallery))
		{
			\dash\notif::error(T_("Invalid festival id"));
			return false;
		}

		$gallery = $load_festival_gallery['gallery'];

		if(is_string($gallery) && (substr($gallery, 0, 1) === '{' || substr($gallery, 0, 1) === '['))
		{
			$gallery = json_decode($gallery, true);
		}
		elseif(is_array($gallery))
		{
			// no thing
		}
		else
		{
			$gallery = [];
		}

		if($_type === 'add')
		{
			if(isset($gallery['gallery']) && is_array($gallery['gallery']))
			{
				if(in_array($_file_index, $gallery['gallery']))
				{
					\dash\notif::error(T_("Duplicate file in this gallery"));
					return false;
				}
				array_push($gallery['gallery'], $_file_index);
			}
			else
			{
				$gallery['gallery'] = [$_file_index];
			}
		}
		else
		{
			if(isset($gallery['gallery']) && is_array($gallery['gallery']))
			{
				if(!array_key_exists($_file_index, $gallery['gallery']))
				{
					\dash\notif::error(T_("Invalid gallery id"));
					return false;
				}
				unset($gallery['gallery'][$_file_index]);
			}

		}

		$gallery = json_encode($gallery, JSON_UNESCAPED_UNICODE);
		\dash\log::db('addFestivalGallery', ['data' => $festival_id, 'datalink' => \dash\coding::encode($festival_id)]);
		\lib\db\festivals::update(['gallery' => $gallery], $festival_id);
		return true;
	}


	public static function get($_id)
	{
		$id = \dash\coding::decode($_id);
		if(!$id)
		{
			\dash\notif::error(T_("Festival id not set"));
			return false;
		}


		$get = \lib\db\festivals::get(['id' => $id, 'limit' => 1]);

		if(!$get)
		{
			\dash\notif::error(T_("Invalid festival id"));
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
		$title = \dash\app::request('title');
		if(!$title && \dash\app::isset_request('title'))
		{
			\dash\notif::error(T_("Please fill the festival title"), 'title');
			return false;
		}


		if($title && mb_strlen($title) > 500)
		{
			\dash\notif::error(T_("Please fill the festival title less than 500 character"), 'title');
			return false;
		}

		if($title)
		{
			$check_duplicate = \lib\db\festivals::get(['title' => $title, 'limit' => 1]);

			if(isset($check_duplicate['id']))
			{
				if(intval($_id) === intval($check_duplicate['id']))
				{
					// no problem to edit it
				}
				else
				{
					\dash\notif::error(T_("Duplicate festival title"), 'title');
					return false;
				}
			}
		}

		$status = \dash\app::request('status');
		if($status && !in_array($status, ['draft','awaiting','enable','expire','cancel', 'deleted', 'disable']))
		{
			\dash\notif::error(T_("Invalid status of festival"), 'status');
			return false;
		}

		$freeuser = \dash\app::request('freeuser');
		$freeuser = $freeuser ? 1 : null;

		$language = \dash\language::current();

		$subtitle = \dash\app::request('subtitle');
		if($subtitle && mb_strlen($subtitle) > 500)
		{
			\dash\notif::error(T_("Please fill the festival subtitle less than 500 character"), 'subtitle');
			return false;
		}


		$slug = \dash\app::request('slug');
		if($slug && mb_strlen($slug) > 200)
		{
			\dash\notif::error(T_("Please fill the festival slug less than 500 character"), 'slug');
			return false;
		}

		if(\dash\app::isset_request('slug'))
		{
			if(!$slug)
			{
				\dash\notif::error(T_("slug of festival can not be null"), 'slug');
				return false;
			}

			if(mb_strlen($slug) < 3)
			{
				\dash\notif::error(T_("festival slug must be larger than 3 character"), 'slug');
				return false;
			}

			if(substr_count($slug, '-') > 10)
			{
				\dash\notif::error(T_("Can not use 2 dash in slug"), 'slug');
				return false;
			}

			if(!preg_match("/^[A-Za-z0-9\-]+$/", $slug))
			{
				\dash\notif::error(T_("Only [A-Za-z0-9] can use in festival slug"), 'slug');
				return false;
			}

			// check slug
			if(mb_strlen($slug) >= 50)
			{
				\dash\notif::error(T_("festival slug must be less than 500 character"), 'slug');
				return false;
			}

			$slug = mb_strtolower($slug);

			$check_duplicate = \lib\db\festivals::get(['slug' => $slug, 'language' => \dash\language::current(), 'limit' => 1]);

			if(isset($check_duplicate['id']))
			{
				if(intval($_id) === intval($check_duplicate['id']))
				{
					// no problem to edit it
				}
				else
				{
					\dash\notif::error(T_("Duplicate festival slug"), 'slug');
					return false;
				}
			}


		}

		if(\dash\app::isset_request('slug') && !$slug)
		{
			\dash\notif::error(T_("Please fill the festival slug"), 'slug');
			return false;
		}

		$sms = \dash\app::request('sms');
		if($sms && mb_strlen($sms) > 500)
		{
			\dash\notif::error(T_("sms is out of range"), 'sms');
			return false;
		}

		$telegram = \dash\app::request('telegram');
		if($telegram && mb_strlen($telegram) > 500)
		{
			\dash\notif::error(T_("telegram is out of range"), 'telegram');
			return false;
		}

		$facebook = \dash\app::request('facebook');
		if($facebook && mb_strlen($facebook) > 500)
		{
			\dash\notif::error(T_("facebook is out of range"), 'facebook');
			return false;
		}

		$twitter = \dash\app::request('twitter');
		if($twitter && mb_strlen($twitter) > 500)
		{
			\dash\notif::error(T_("twitter is out of range"), 'twitter');
			return false;
		}

		$instagram = \dash\app::request('instagram');
		if($instagram && mb_strlen($instagram) > 500)
		{
			\dash\notif::error(T_("instagram is out of range"), 'instagram');
			return false;
		}

		$linkedin = \dash\app::request('linkedin');
		if($linkedin && mb_strlen($linkedin) > 500)
		{
			\dash\notif::error(T_("linkedin is out of range"), 'linkedin');
			return false;
		}

		$website = \dash\app::request('website');
		if($website && mb_strlen($website) > 500)
		{
			\dash\notif::error(T_("website is out of range"), 'website');
			return false;
		}

		$desc       = \dash\app::request('desc');
		$intro      = \dash\app::request('intro');
		$about      = \dash\app::request('about');
		$target     = \dash\app::request('target');
		$axis       = \dash\app::request('axis');
		$view       = \dash\app::request('view');
		$schedule   = \dash\app::request('schedule');
		$logo       = \dash\app::request('logo');
		$gallery    = \dash\app::request('gallery');
		$place      = \dash\app::request('place');
		$award      = \dash\app::request('award');
		$phone      = \dash\app::request('phone');
		$address    = \dash\app::request('address');
		$email      = \dash\app::request('email');
		$poster     = \dash\app::request('poster');
		$brochure   = \dash\app::request('brochure');
		$message    = \dash\app::request('message');
		$messagesms = \dash\app::request('messagesms');


		$args               = [];
		$args['desc']       = $desc;
		$args['intro']      = $intro;
		$args['about']      = $about;
		$args['target']     = $target;
		$args['axis']       = $axis;
		$args['view']       = $view;
		$args['schedule']   = $schedule;
		$args['logo']       = $logo;
		$args['gallery']    = $gallery;
		$args['place']      = $place;
		$args['award']      = $award;
		$args['phone']      = $phone;
		$args['address']    = $address;
		$args['email']      = $email;
		$args['poster']     = $poster;
		$args['brochure']   = $brochure;
		$args['message']    = $message;
		$args['messagesms'] = $messagesms;
		$args['title']      = $title;
		$args['status']     = $status;
		$args['freeuser']   = $freeuser;
		$args['subtitle']   = $subtitle;
		$args['slug']       = $slug;
		$args['sms']        = $sms;
		$args['telegram']   = $telegram;
		$args['facebook']   = $facebook;
		$args['twitter']    = $twitter;
		$args['instagram']  = $instagram;
		$args['linkedin']   = $linkedin;
		$args['website']    = $website;
		$args['language']   = $language;


		return $args;
	}


	/**
	 * ready data of festival to load in api
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
					$result[$key] = \dash\coding::encode($value);
					break;

				case 'gallery':
					$result[$key] = json_decode($value, true);
					break;

				case 'logo':
					if($value)
					{
						$result[$key] = $value;
					}
					else
					{
						$result[$key] = \dash\app::static_logo_url();
					}
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