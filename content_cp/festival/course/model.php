<?php
namespace content_cp\festival\course;


class model
{
	public static function post()
	{
		if(\dash\request::get('type') === 'add' || \dash\request::get('course'))
		{
			\dash\permission::access('fpCourseAdd');

			$post                  = [];
			$post['title']         = \dash\request::post('title');
			$post['festival_id']   = \dash\request::get('id');
			$post['subtitle']      = \dash\request::post('subtitle');
			$post['group']         = \dash\request::post('group');
			$post['desc']          = \dash\request::post('desc');
			$post['condition']     = \dash\request::post('condition') ? $_POST['condition'] : null;
			$post['conditionsend'] = \dash\request::post('conditionsend') ? $_POST['conditionsend'] : null;
			$post['price']         = \dash\request::post('price');
			$post['multiuse']      = \dash\request::post('multiuse');

			if(\dash\request::get('course'))
			{
				$post['status']        = \dash\request::post('status');
			}

			if(\dash\request::get('course'))
			{
				$result = \lib\app\festivalcourse::edit($post, \dash\request::get('course'));
				if(\dash\engine\process::status())
				{
					\dash\redirect::pwd();
				}
			}
			else
			{
				$result = \lib\app\festivalcourse::add($post);

				if(\dash\engine\process::status())
				{
					if(isset($result['id']))
					{
						\dash\redirect::to(\dash\url::this(). '/course?id='. \dash\request::get('id'). '&course='. $result['id']);
					}
					else
					{
						\dash\redirect::to(\dash\url::this());
					}
				}
			}
		}
	}
}
?>
