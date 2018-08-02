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
			if(\dash\request::get('type') === 'rules')
			{
				$post['condition']     = \dash\request::post('condition') ? $_POST['condition'] : null;
			}
			elseif(\dash\request::get('type') === 'sendrule')
			{
				$post['conditionsend'] = \dash\request::post('conditionsend') ? $_POST['conditionsend'] : null;
			}
			elseif(\dash\request::get('type') === 'setting')
			{

			}
			elseif(\dash\request::get('type') === 'files')
			{
				$post['price']         = \dash\request::post('price');
				$post['multiuse']      = \dash\request::post('multiuse');
			}
			else
			{
				$post['title']         = \dash\request::post('title');
				$post['subtitle']      = \dash\request::post('subtitle');
				$post['group']         = \dash\request::post('group');
				$post['desc']          = \dash\request::post('desc');

				if(\dash\request::get('course'))
				{
					$post['status']        = \dash\request::post('status');
				}
			}

			$post['festival_id']   = \dash\request::get('id');

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
