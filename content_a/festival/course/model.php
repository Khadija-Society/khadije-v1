<?php
namespace content_a\festival\course;


class model
{
	public static function post()
	{
		if(\dash\request::post('pay'))
		{
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
			$course_id = \dash\coding::decode($course);
			$course = \lib\app\festivalcourse::get($course);

			if(!$course || !array_key_exists('price', $course))
			{
				\dash\header::status(404, T_("Invalid course id"));
			}

			if(self::check_duplicate($course_id))
			{
				\dash\notif::error(T_("You register to this course before"));
				return false;
			}

			$price = abs(intval($course['price']));
			if(!$price)
			{

				if(!self::signup_course(['course_id' => $course_id, 'festival_id' => \dash\request::get('id')]))
				{
					\dash\notif::error(T_("We can not register you on this course"));
					return false;
				}

				\dash\notif::ok(T_("You are register to this course"));
				\dash\redirect::to(\dash\url::this(). '/request?'. http_build_query(['id' => \dash\request::get('id'), 'course' => \dash\request::get('course')]));
				return true;
			}
			else
			{


				$meta =
				[
					'turn_back'     => \dash\url::pwd(),
					'user_id'       => \dash\user::id(),
					'auto_go'       => true,
					'amount'        => $price,
					'final_fn'      => ['/content_a/festival/course/model','signup_course'],
					'final_fn_args' => ['course_id' => $course_id, 'festival_id' => \dash\request::get('id')],
					'other_field'   =>
					[
						'hazinekard' => $festival_id,
						'niyat'      => $course_id,
						'fullname'   => \dash\user::login('displayname'),
						'donate'     => 'festival',
						'doners'     => 0,
					]
				];
				\dash\utility\pay\start::site($meta);

			}


		}
	}


	public static function signup_course($_detail)
	{
		if(isset($_detail['course_id']))
		{
			$course_id = $_detail['course_id'];
		}

		if(isset($_detail['festival_id']))
		{
			$festival_id = $_detail['festival_id'];
		}

		if($course_id && $festival_id)
		{
			// no problem
		}
		else
		{
			return false;
		}

		if(self::check_duplicate($course_id))
		{
			return false;
		}

		$festival_id = \dash\coding::decode($festival_id);

		if(!$festival_id || !is_numeric($festival_id))
		{
			return false;
		}

		$insert =
		[
			'festival_id'       => $festival_id,
			'festivalcourse_id' => $course_id,
			'user_id'           => \dash\user::id(),
			'status'            => 'draft',
		];

		$insert = \lib\db\festivalusers::insert($insert);

		if($insert)
		{
			return true;
		}

		return false;
	}


	public static function check_duplicate($_course_id)
	{
		$festival_id = \dash\request::get('id');
		$festival_id = \dash\coding::decode($festival_id);
		if(!$festival_id || !is_numeric($festival_id))
		{
			return false;
		}

		$check_duplicate =
		[
			'festival_id'       => $festival_id,
			'festivalcourse_id' => $_course_id,
			'user_id'           => \dash\user::id(),
			'limit'             => 1
		];

		$check_duplicate = \lib\db\festivalusers::get($check_duplicate);

		if($check_duplicate)
		{
			return $check_duplicate;
		}

		return false;
	}


}
?>
