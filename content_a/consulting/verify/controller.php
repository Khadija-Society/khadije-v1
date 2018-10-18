<?php
namespace content_a\consulting\verify;


class controller
{
	public static function routing()
	{
		if(!\dash\user::login())
		{
			\dash\redirect::to(\dash\url::kingdom(). '/enter');
			return;
		}


		$id = \dash\request::get('id');

		if(!$id || !is_numeric($id))
		{
			\dash\header::status(403, T_("Id not found"));
		}

		$need = \lib\db\needs::get(['id' => $id, 'type' => 'consulting', 'status' => 'enable', 'limit' => 1]);

		if(!isset($need['id']))
		{
			\dash\header::status(403, T_("Id not found"));
		}

		if(!isset($need['term']))
		{
			\dash\redirect::to(\dash\url::this(). '/request');
		}

		\dash\data::currentNeed($need);

	}
}
?>
