<?php
namespace content_cp\options\cityplace;


class model extends \addons\content_cp\main\model
{

	public function post_cityplace()
	{
		if(\lib\utility::post('type') === 'delete' && \lib\utility::post('key'))
		{
			if(\lib\app\travel::remove_cityplace(\lib\utility::post('key')))
			{
				\lib\debug::warn(T_("The city place successfully removed"));
			}
			else
			{
				return;
			}
		}
		else
		{
			\lib\app\travel::set_cityplace(\lib\utility::post('city'), \lib\utility::post('place'));

			if(\lib\debug::$status)
			{
				\lib\debug::true(T_("City place successfully added"));
			}
		}

		if(\lib\debug::$status)
		{
			$this->redirector(\lib\url::pwd());
		}

	}
}
?>
