<?php
namespace content_smsapp\editgroup;


class controller
{
	public static function block_group_id($_decode = false)
	{
		$code =  'm';
		if($_decode)
		{
			$code = \dash\coding::decode($code);
		}
		return $code;
	}

	public static function secret_group_id($_decode = false)
	{
		$code =  '7';
		if($_decode)
		{
			$code = \dash\coding::decode($code);
		}
		return $code;
	}

	public static function routing()
	{
		\dash\permission::access('smsAppSetting');

		$id = null;

		if(\dash\url::child() === 'block' && !\dash\url::subchild())
		{
			\dash\data::blockMode(true);
			\dash\open::get();
			\dash\open::post();
			$id = self::block_group_id();
		}


		if(\dash\url::child() === 'secret' && !\dash\url::subchild())
		{
			\dash\data::secretMode(true);
			\dash\open::get();
			\dash\open::post();
			$id = self::secret_group_id();
		}

		if(!$id)
		{
			$id   = \dash\request::get('id');
		}

		\dash\data::myId($id);

		$load = \lib\app\smsgroup::get($id);

		if(!$load)
		{
			\dash\header::status(404);
		}

		\dash\data::dataRow($load);

		\content_smsapp\controller::do_not_tuch();

	}
}
?>
