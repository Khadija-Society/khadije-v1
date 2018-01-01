<?php
namespace content_a\trip\partner;


class model extends \content_a\main\model
{

	public function post_partner()
	{
		if(\lib\utility::post('next') === 'next')
		{
			$this->redirector($this->url('baseFull'). '/trip');
			return;
		}

		if(\lib\utility::post('type') === 'remove' && \lib\utility::post('key') != '' && ctype_digit(\lib\utility::post('key')))
		{
			\lib\db\travelusers::remove(\lib\utility::post('key'), \lib\utility::get('trip'));
			if(\lib\debug::$status)
			{
				$this->redirector($this->url('baseFull'). '/trip/partner?trip='. \lib\utility::get('trip'));
			}
		}
		else
		{

			$post                    = [];
			$post['firstname']       = \lib\utility::post('name');
			$post['lastname']        = \lib\utility::post('lastName');
			$post['father']          = \lib\utility::post('father');
			$post['nationalcode']    = \lib\utility::post('nationalcode');
			$post['birthday']        = \lib\utility::post('birthday');
			$post['gender']          = \lib\utility::post('gender') ? 'female' : 'male';
			$post['married']         = \lib\utility::post('Married') ? 'married' : 'single';
			$post['nesbat']          = \lib\utility::post('nesbat');

			$post['travel_id']       = \lib\utility::get('trip');

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
