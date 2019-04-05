<?php
namespace content_a\trip\partner;


class model
{

	public static function post()
	{
		if(\dash\request::post('next') === 'next')
		{
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

			\dash\redirect::to(\dash\url::here(). '/trip?success=yes');
			return;
		}

		if(\dash\request::post('type') === 'remove' && \dash\request::post('key') != '' && ctype_digit(\dash\request::post('key')))
		{
			\lib\db\travelusers::remove(\dash\request::post('key'), \dash\request::get('trip'));
			if(\dash\engine\process::status())
			{
				\dash\redirect::to(\dash\url::here(). '/trip/partner?trip='. \dash\request::get('trip'));
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

			$post['travel_id']    = \dash\request::get('trip');

			$file1 = \dash\app\file::upload_quick('file1');

			// if(!$file1)
			// {
			// 	\dash\notif::error(T_("Plase set nationalcode thumb"));
			// 	return false;
			// }

			if($file1)
			{
				$post['file1'] = $file1;
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
