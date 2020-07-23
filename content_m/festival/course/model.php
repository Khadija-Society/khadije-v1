<?php
namespace content_m\festival\course;


class model
{
	public static function post()
	{
		if(\dash\request::get('type') === 'add' || \dash\request::get('course'))
		{
			\dash\permission::access('cpFestivalCourseEdit');

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
				$post['price']     = \dash\request::post('price');
				$link              = [];
				$link['link']      = \dash\request::post('link') ? $_POST['link'] : null;
				$link['linktitle'] = \dash\request::post('linktitle');
				$post['link']      = json_encode($link, JSON_UNESCAPED_UNICODE);

			}
			elseif(\dash\request::get('type') === 'files')
			{
				$allowfile             = [];
				$allowfile['word']     = \dash\request::post('word') ? true : false;
				$allowfile['pdf']      = \dash\request::post('pdf') ? true : false;
				$allowfile['video']    = \dash\request::post('video') ? true : false;
				$allowfile['sound']    = \dash\request::post('sound') ? true : false;
				$allowfile['apk']      = \dash\request::post('apk') ? true : false;
				$allowfile['zip']      = \dash\request::post('zip') ? true : false;
				$allowfile['other']    = \dash\request::post('other') ? true : false;
				$allowfile['filesize'] = \dash\request::post('filesize');
				$post['allowfile']     = json_encode($allowfile, JSON_UNESCAPED_UNICODE);
			}
			elseif(\dash\request::get('type') === 'add')
			{
				$post['title']         = \dash\request::post('title');
			}
			else
			{
				$post['title']         = \dash\request::post('title');
				$post['subtitle']      = \dash\request::post('subtitle');
				$post['group']         = \dash\request::post('group');
				$post['desc']          = \dash\request::post('desc');

				$file = \dash\app\file::upload_quick('file');
				if($file)
				{
					$post['file'] = $file;
				}

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
