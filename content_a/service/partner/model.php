<?php
namespace content_a\service\partner;


class model extends \content_a\main\model
{

	public function post_partner()
	{
		if(\lib\utility::post('next') === 'next')
		{
			\lib\db\travels::update(['status' => 'awaiting'], \lib\utility::get('service'));
			// send next
			if(\lib\user::detail('mobile') && \lib\utility\filter::mobile(\lib\user::detail('mobile')))
			{
				$travel_detail = \lib\db\travels::get(['id' => \lib\utility::get('service'), 'limit' => 1]);
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

			$this->redirector($this->url('baseFull'). '/service');
			return;
		}

		if(\lib\utility::post('type') === 'remove' && \lib\utility::post('key') != '' && ctype_digit(\lib\utility::post('key')))
		{
			\lib\db\travelusers::remove(\lib\utility::post('key'), \lib\utility::get('service'));
			if(\lib\debug::$status)
			{
				$this->redirector($this->url('baseFull'). '/service/partner?service='. \lib\utility::get('service'));
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

			$post['travel_id']    = \lib\utility::get('service');

			\lib\app\myuser::add_child($post);

			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("Your Child was saved"));
				$this->redirector($this->url('full'));
			}

		}

	}

}
?>
