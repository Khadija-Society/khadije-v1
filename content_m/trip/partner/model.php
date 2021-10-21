<?php
namespace content_m\trip\partner;


class model
{
	public static function getPost()
	{
		\dash\permission::access('cpTripEdit');

		$post                 = [];
		$post['firstname']    = \dash\request::post('name');
		$post['lastname']     = \dash\request::post('lastName');
		$post['father']       = \dash\request::post('father');
		$post['mobile2']      = \dash\request::post('mobile');
		$post['nationalcode'] = \dash\request::post('nationalcode');
		$post['birthday']     = \dash\request::post('birthday');
		$post['gender']       = \dash\request::post('gender') ? 'female' : 'male';
		$post['married']      = \dash\request::post('Married') ? 'married' : 'single';
		$post['nesbat']       = \dash\request::post('nesbat');
		$post['kind']         = \dash\request::post('kind');
		$post['type']         = \dash\request::post('type');
		$file1 = \dash\app\file::upload_quick('file1');
		if($file1)
		{
			$post['file1'] = $file1;
		}

		return $post;
	}


	public static function post()
	{
		$file = \dash\app\file::upload_quick('partnerFile');
		if($file)
		{
			$travelPartner = \lib\db\travelusers::get_travel_child(\dash\request::get('id'));
			if($travelPartner)
			{
				\dash\notif::error(T_("You can not add any partner to this trip"));
				\dash\redirect::pwd();
				return;
			}

			self::import($file);

			if(\dash\engine\process::status())
			{
				\dash\redirect::pwd();
			}

			return;
		}

		if(\dash\request::post('export') === 'export_partner')
		{

			\dash\utility\export::csv(['name' => 'export_trip_'. \dash\request::get('id'), 'data' => \dash\data::travelPartner()]);

			return;
		}

		if(\dash\request::post('type') === 'remove' && \dash\request::post('key') != '' && ctype_digit(\dash\request::post('key')))
		{
			\dash\log::set('removePartnerGroupTrip', ['code' => \dash\request::get('id')]);
			\lib\db\travelusers::remove(\dash\request::post('key'), \dash\request::get('id'));
			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("Partner successfully removed"));
				\dash\redirect::pwd();
			}
		}
		elseif(\dash\request::post('save_child') === 'save_child')
		{
			$post = self::getPost();
			$post['not_force_birthday'] = true;

			$post['travel_id']       = \dash\request::get('id');

			\lib\app\myuser::add_child($post);

			if(\dash\engine\process::status())
			{
				\dash\log::set('AddPartnerGroupTrip', ['code' => \dash\request::get('id')]);
				\dash\notif::ok(T_("Your Child was saved"));
				\dash\redirect::to(\dash\url::that(). '?id='. \dash\request::get('id'));
			}

		}
		elseif(\dash\request::post('edit_child') === 'edit_child' && \dash\request::get('partner') && is_numeric(\dash\request::get('partner')))
		{
			$post              = self::getPost();
			$post['travel_id'] = \dash\request::get('id');

			$get_user_id = \lib\db\travelusers::get(['id' => \dash\request::get('partner'), 'travel_id' => \dash\request::get('id'), 'limit' => 1]);

			if(isset($get_user_id['user_id']))
			{
				$user_id = $get_user_id['user_id'];
			}
			else
			{
				\dash\notif::error(T_("Invalid user travel detail"));
				return false;
			}

			\lib\app\myuser::edit_child($post, $user_id, ['trip_id' => \dash\request::get('id')]);

			if(\dash\engine\process::status())
			{
				\dash\log::set('editPartnerGroupTrip', ['code' => \dash\request::get('id')]);
				\dash\notif::ok(T_("The partner was updated"));
				\dash\redirect::to(\dash\url::that(). '?id='. \dash\request::get('id'));
			}
		}

	}


	public static function send_sms($_status)
	{
		$mobile        = null;
		$msg           = '';
		$travelDetail = \lib\db\travels::get(['id' => \dash\request::get('id'), 'limit' => 1]);
		if(!isset($travelDetail['user_id']))
		{
			return;
		}

		$load_user = \dash\db\users::get_by_id($travelDetail['user_id']);
		if(!isset($load_user['mobile']))
		{
			return;
		}
		if(!\dash\utility\filter::mobile($load_user['mobile']))
		{
			return;
		}

		$mobile = $load_user['mobile'];

		if(isset($travelDetail['place']))
		{
			$city = T_($travelDetail['place']);
		}

		switch ($_status)
		{
			case 'awaiting':
				$msg = "درخواست تشرف به $city در حال انتظمار است.";
				break;

			case 'review':
				$msg = "درخواست تشرف به $city در دست بررسی است. بزودی با شما تماس خواهیم گرفت.";
				break;

			case 'queue':
				$msg = "درخواست تشرف به $city در تایید شده و شما در صف تشرف قرار گرفته‌اید.";
				break;

			case 'notanswer':
				$msg = "برای درخواست تشرف به $city با شما تماس گرفته شد و پاسخگو نبودید.";
				break;


			case 'spam':
			case 'draft':
			case 'cancel':
			case 'gone':
			case 'reject':
			case 'admincancel':

				break;

			default:
				break;
		}

		if($msg && $mobile)
		{
			\dash\utility\sms::send($mobile, $msg);
		}
	}



	private static function import($_addr)
	{
		$get = \dash\utility\import::csv($_addr);
		if(!is_array($get))
		{
			\dash\notif::error(T_("File is not valid"));
			return false;
		}

		$check = self::check_import($get);

		if(!$check)
		{
			return false;
		}

		$i = 0;
		foreach ($check as $key => $value)
		{
			if($value)
			{
				$i++;
				$add_new                       = $value;


				$add_new['not_force_birthday'] = true;
				$add_new['travel_id']          = \dash\request::get('id');

				\lib\app\myuser::add_child($add_new, ['import_mode' => true]);

				\dash\engine\process::continue();
			}
		}

		\dash\notif::ok(T_("Import successfully"). ', '. T_(":val rows imported", ['val' => \dash\utility\human::fitNumber($i)]));
		return true;
	}


	private static function check_import($_array)
	{
		$is_ok = true;
		$new_value = [];
		foreach ($_array as $key => $value)
		{
			\dash\engine\process::continue();
			\dash\app::variable($value);

			$temp = \lib\app\myuser::check(['import_mode' => false]);

			if($temp === false || !\dash\engine\process::status())
			{
				if($is_ok)
				{
					$is_ok = false;
					\dash\notif::info(T_("Error in line :line", ['line' => $key + 1]));
				}
				// return false;
			}
			$new_value[] = $temp;



		}

		return $new_value;
	}
}
?>
