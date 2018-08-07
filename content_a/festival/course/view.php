<?php
namespace content_a\festival\course;


class view
{
	public static function config()
	{
		if(\dash\session::get('payment_request_start'))
		{
			if(\dash\utility\payment\verify::get_status())
			{
				$amount = \dash\utility\payment\verify::get_amount();
				\dash\data:: paymentVerifyMsgTrue(true);
				\dash\data:: paymentVerifyMsg(T_("You are signuped to this course"));

				$course_id = \dash\coding::decode(\dash\request::get('course'));

				\dash\session::set('singup_festival_course_id', null);

				if(!\content_a\festival\course\model::signup_course($course_id))
				{
					\dash\notif::error(T_("We can not register you on this course"));
				}
				else
				{
					\dash\notif::ok(T_("You are register to this course"));
					\dash\utility\payment\verify::clear_session();
					\dash\redirect::to(\dash\url::this(). '/request?'. http_build_query(['id' => \dash\request::get('id'), 'course' => \dash\request::get('course')]));

				}
			}
			else
			{
				\dash\data:: paymentVerifyMsgTrue(false);
				\dash\data:: paymentVerifyMsg(T_("Payment unsuccessfull"));
			}

			\dash\utility\payment\verify::clear_session();
		}

		\dash\data::page_title(T_("Festival course list"));
		\dash\data::page_desc(T_('You can signup in some festival course'));

		\dash\data::badge_link(\dash\url::here());
		\dash\data::badge_text(T_('Back to dashboard'));

		$id  = \dash\request::get('id');

		if(!$id || !is_numeric($id))
		{
			\dash\redirect::to(\dash\url::here());
		}

		$load = \lib\app\festival::get($id);

		if(!$load)
		{
			\dash\header::status(403, T_("Invalid festival id"));
		}

		$festival_id = \dash\coding::decode($id);

		$course = \dash\request::get('course');
		$course = \lib\app\festivalcourse::get($course);

		if(!$course)
		{
			\dash\header::status(404, T_("Invalid course id"));
		}

		$check_duplicate = \content_a\festival\course\model::check_duplicate(\dash\coding::decode(\dash\request::get('course')));
		\dash\data::checkDuplicate($check_duplicate);

		\dash\data::course($course);
	}
}
?>
