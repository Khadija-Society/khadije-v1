<?php
namespace content_cp\donate\options;


class model extends \addons\content_cp\main\model
{

	public function post_donate()
	{
		if(\lib\utility::post('type') === 'delete' && \lib\utility::post('key'))
		{
			if(\lib\app\donate::remove_way(\lib\utility::post('key')))
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
			$way = \lib\utility::post('way');

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
