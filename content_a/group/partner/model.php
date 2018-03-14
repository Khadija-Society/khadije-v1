<?php
namespace content_a\group\partner;


class model extends \content_a\main\model
{

	public function post_partner()
	{
		if(\lib\utility::post('next') === 'next')
		{
			$count_partner = \lib\db\travelusers::get(['travel_id' => \lib\utility::get('trip')]);
			$min           = \lib\app\travel::group_count_partner_min();

			if(count($count_partner) < $min)
			{
				\lib\debug::error(T_("You must register at least :min partner", ['min' => \lib\utility\convert::to_fa_number($min)]));
				return false;
			}

			\lib\db\travels::update(['status' => 'awaiting'], \lib\utility::get('trip'));
			// send next
			if(\lib\user::detail('mobile') && \lib\utility\filter::mobile(\lib\user::detail('mobile')))
			{
				$travel_detail = \lib\db\travels::get(['id' => \lib\utility::get('trip'), 'limit' => 1]);
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

			$this->redirector(\lib\url::here(). '/group');
			return;
		}

		if(\lib\utility::post('type') === 'remove' && \lib\utility::post('key') != '' && ctype_digit(\lib\utility::post('key')))
		{
			\lib\db\travelusers::remove(\lib\utility::post('key'), \lib\utility::get('trip'));
			if(\lib\debug::$status)
			{
				$this->redirector(\lib\url::here(). '/group/partner?trip='. \lib\utility::get('trip'));
			}
		}
		else
		{

			$post                 = [];
			$post['firstname']    = \lib\utility::post('name');
			$post['lastname']     = \lib\utility::post('lastName');
			$post['father']       = \lib\utility::post('father');
			$post['nationalcode'] = \lib\utility::post('nationalcode');
			$post['birthday']     = \lib\utility::post('birthday');
			$post['gender']       = \lib\utility::post('gender') ;
			$post['pasportcode']  = \lib\utility::post('passport') ;

			$post['married']      = \lib\utility::post('Married');
			$post['nesbat']       = \lib\utility::post('nesbat');
			$post['type']         = 'group';

			$post['travel_id']    = \lib\utility::get('trip');

			\lib\app\myuser::add_child($post);

			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("Your Child was saved"));
				$this->redirector(\lib\url::pwd());
			}

		}

	}

}
?>
