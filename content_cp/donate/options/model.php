<?php
namespace content_cp\donate\options;


class model extends \addons\content_cp\main\model
{

	public function post_donate()
	{
		if(\lib\request::post('type') === 'delete' && \lib\request::post('key'))
		{
			if(\lib\app\donate::remove_way(\lib\request::post('key')))
			{
				\lib\debug::warn(T_("The way successfully removed"));
			}
			else
			{
				return;
			}
		}
		else
		{
			$way = \lib\request::post('way');

			\lib\app\donate::set_way($way);

			\lib\debug::true(T_("Way successfully added"));
		}

		if(\lib\debug::$status)
		{
			$this->redirector(\lib\url::pwd());
		}
	}
}
?>
