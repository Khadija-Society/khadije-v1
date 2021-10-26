<?php
namespace content_a\group\partner;


class model
{

	public static function post()
	{
		if(\dash\request::post('next') === 'next')
		{
			$count_partner = \lib\db\travelusers::get(['travel_id' => \dash\request::get('trip')]);
			$min           = \lib\app\travel::group_count_partner_min();

			if(count($count_partner) < $min)
			{
				\dash\notif::error(T_("You must register at least :min partner", ['min' => \dash\utility\convert::to_fa_number($min)]));
				return false;
			}

			\lib\db\travels::update(['status' => 'awaiting'], \dash\request::get('trip'));
			// send next
			if(\dash\user::detail('mobile') && \dash\utility\filter::mobile(\dash\user::detail('mobile')))
			{
				$travelDetail = \lib\db\travels::get(['id' => \dash\request::get('trip'), 'limit' => 1]);
				if(isset($travelDetail['place']))
				{
					$city = T_($travelDetail['place']);
					$msg = "درخواست شما برای تشرف به $city با موفقیت ثبت شد.";
				}
				else
				{
					$msg = "درخواست شما برای تشرف با موفقیت ثبت شد.";
				}

				\dash\utility\sms::send(\dash\user::detail('mobile'), $msg);
			}

			\dash\redirect::to(\dash\url::here(). '/group');
			return;
		}

		if(\dash\request::post('type') === 'remove' && \dash\request::post('key') != '' && ctype_digit(\dash\request::post('key')))
		{
			\lib\db\travelusers::remove(\dash\request::post('key'), \dash\request::get('trip'));
			if(\dash\engine\process::status())
			{
				\dash\redirect::to(\dash\url::here(). '/group/partner?trip='. \dash\request::get('trip'));
			}
		}
		else
		{

			$post                 = [];
			$post['firstname']    = \dash\request::post('name');
			$post['lastname']     = \dash\request::post('lastName');
			$post['father']       = \dash\request::post('father');
			$post['nationalcode'] = \dash\request::post('nationalcode');
			$post['birthday']     = \dash\request::post('birthday');
			$post['gender']       = \dash\request::post('gender') ;
			$post['pasportcode']  = \dash\request::post('passport') ;

			$post['mobile2']      = \dash\request::post('mobile');
			$post['married']      = \dash\request::post('Married');
			$post['nesbat']       = \dash\request::post('nesbat');
			$post['type']         = 'group';
			$post['kind'] = 'master';


			if(!$post['mobile2'])
			{
				\dash\notif::error(T_("Mobile is required"), 'mobile');
				return false;
			}

			$post['travel_id']    = \dash\request::get('trip');

			$file1 = \dash\app\file::upload_quick('file1');

			if(\dash\data::tripDetail_place() === 'qom')
			{
				$post['not_force_birthday'] = true;
			}

			// if(!$file1)
			// {
			// 	\dash\notif::error(T_("Plase set nationalcode thumb"));
			// 	return false;
			// }

			if($file1)
			{
				$post['file1'] = $file1;
			}

			if(\dash\data::tripDetail_place() === 'mashhad')
			{
				if(!$file1)
				{
					\dash\notif::error(T_("Pleas upload partner nationalcode thumb"), 'file1');
					return false;
				}

				if(!$post['mobile2'])
				{
					\dash\notif::error(T_("Pleas fill mobile"), 'mobile');
					return false;
				}

				if(!$post['father'])
				{
					\dash\notif::error(T_("Pleas fill father name"), 'father');
					return false;
				}

			}

			\lib\app\myuser::add_child($post);

			if(\dash\engine\process::status())
			{
				\dash\notif::ok(T_("Your Child was saved"));
				\dash\redirect::pwd();
			}

		}

	}

}
?>
