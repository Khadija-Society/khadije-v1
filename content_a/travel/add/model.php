<?php
namespace content_a\travel\add;


class model extends \content_a\main\model
{

	public function post_travel()
	{

		if(\lib\utility::post('remove') === \lib\utility::get('edit') && \lib\utility::get('edit') != '')
		{
			\lib\app\travel::remove(\lib\utility::get('edit'));
			if(\lib\debug::$status)
			{
				$this->redirector($this->url('baseFull'). '/travel');
			}
		}
		else
		{

			$post              = [];
			$post['cityplace'] = \lib\utility::post('city');
			$post['startdate'] = \lib\utility::post('startdate');
			$post['enddate']   = \lib\utility::post('enddate');

			$all_post = \lib\utility::post();

			$child = [];
			foreach ($all_post as $key => $value)
			{
				if(preg_match("/^(child)\_(\d+)$/", $key, $split) && $value === 'on')
				{
					if(isset($split[2]))
					{
						array_push($child, $split[2]);
					}
				}
			}

			$post['child'] = $child;

			if(\lib\utility::get('edit') && \lib\utility::get('edit') != '')
			{
				\lib\app\travel::edit($post, \lib\utility::get('edit'));
			}
			else
			{
				\lib\app\travel::add($post);
			}

			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("Your Travel was saved"));
				$this->redirector($this->url('baseFull'). '/travel');
			}

		}

	}

}
?>
