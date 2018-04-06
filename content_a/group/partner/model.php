<?php
namespace content_a\group\partner;


class model extends \content_a\main\model
{

	public function post_partner()
	{
		if(\dash\request::post('next') === 'next')
		{
			$count_partner = \lib\db\travelusers::get(['travel_id' => \dash\request::get('trip')]);
			$min           = \lib\app\travel::group_count_partner_min();

			if(count($count_partner) < $min)
			{
				\lib\notif::error(T_("You must register at least :min partner", ['min' => \dash\utility\convert::to_fa_number($min)]));
				return false;
			}

			\lib\db\travels::update(['status' => 'awaiting'], \dash\request::get('trip'));
			// send next
			if(\lib\user::detail('mobile') && \dash\utility\filter::mobile(\lib\user::detail('mobile')))
			{
				$travel_detail = \lib\db\travels::get(['id' => \dash\request::get('trip'), 'limit' => 1]);
				if(isset($travel_detail['place']))
				{
					$city = T_($travel_detail['place']);
					$msg = "درخواست شما برای تشرف به $city با موفقیت ثبت شد.";
				}
				else
				{
					$msg = "درخواست شما برای تشرف با موفقیت ثبت شد.";
				}

				\dash\utility\sms::send(\lib\user::detail('mobile'), $msg);
			}

			\lib\redirect::to(\dash\url::here(). '/group');
			return;
		}

		if(\dash\request::post('type') === 'remove' && \dash\request::post('key') != '' && ctype_digit(\dash\request::post('key')))
		{
			\lib\db\travelusers::remove(\dash\request::post('key'), \dash\request::get('trip'));
			if(\lib\engine\process::status())
			{
				\lib\redirect::to(\dash\url::here(). '/group/partner?trip='. \dash\request::get('trip'));
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

			$post['married']      = \dash\request::post('Married');
			$post['nesbat']       = \dash\request::post('nesbat');
			$post['type']         = 'group';

			$post['travel_id']    = \dash\request::get('trip');

			\lib\app\myuser::add_child($post);

			if(\lib\engine\process::status())
			{
				\lib\notif::ok(T_("Your Child was saved"));
				\lib\redirect::pwd();
			}

		}

	}

}
?>
