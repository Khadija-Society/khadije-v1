<?php
namespace content_a\group\partner;


class model extends \content_a\main\model
{

	public function post_partner()
	{
		if(\lib\request::post('next') === 'next')
		{
			$count_partner = \lib\db\travelusers::get(['travel_id' => \lib\request::get('trip')]);
			$min           = \lib\app\travel::group_count_partner_min();

			if(count($count_partner) < $min)
			{
				\lib\debug::error(T_("You must register at least :min partner", ['min' => \lib\utility\convert::to_fa_number($min)]));
				return false;
			}

			\lib\db\travels::update(['status' => 'awaiting'], \lib\request::get('trip'));
			// send next
			if(\lib\user::detail('mobile') && \lib\utility\filter::mobile(\lib\user::detail('mobile')))
			{
				$travel_detail = \lib\db\travels::get(['id' => \lib\request::get('trip'), 'limit' => 1]);
				if(isset($travel_detail['place']))
				{
					$city = T_($travel_detail['place']);
					$msg = "درخواست شما برای تشرف به $city با موفقیت ثبت شد.";
				}
				else
				{
					$msg = "درخواست شما برای تشرف با موفقیت ثبت شد.";
				}

				\lib\utility\sms::send(\lib\user::detail('mobile'), $msg);
			}

			\lib\redirect::to(\lib\url::here(). '/group');
			return;
		}

		if(\lib\request::post('type') === 'remove' && \lib\request::post('key') != '' && ctype_digit(\lib\request::post('key')))
		{
			\lib\db\travelusers::remove(\lib\request::post('key'), \lib\request::get('trip'));
			if(\lib\debug::$status)
			{
				\lib\redirect::to(\lib\url::here(). '/group/partner?trip='. \lib\request::get('trip'));
			}
		}
		else
		{

			$post                 = [];
			$post['firstname']    = \lib\request::post('name');
			$post['lastname']     = \lib\request::post('lastName');
			$post['father']       = \lib\request::post('father');
			$post['nationalcode'] = \lib\request::post('nationalcode');
			$post['birthday']     = \lib\request::post('birthday');
			$post['gender']       = \lib\request::post('gender') ;
			$post['pasportcode']  = \lib\request::post('passport') ;

			$post['married']      = \lib\request::post('Married');
			$post['nesbat']       = \lib\request::post('nesbat');
			$post['type']         = 'group';

			$post['travel_id']    = \lib\request::get('trip');

			\lib\app\myuser::add_child($post);

			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("Your Child was saved"));
				\lib\redirect::pwd();
			}

		}

	}

}
?>
