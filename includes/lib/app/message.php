<?php
namespace lib\app;

class message
{
	public static function get()
	{
		$get = self::file();
		if(!$get)
		{
			return null;
		}

		$result = [];

		$explode = explode("\n\n-----\n\n", $get);
		if(isset($explode[0]))
		{
			$setting = explode("\n", $explode[0]);
			foreach ($setting as $key => $value)
			{
				$result[substr($value, 2)] = (bool) substr($value, 0, 1);
			}

		}
		if(isset($explode[1]))
		{
			$result['text'] = $explode[1];
		}
		return $result;
	}


	public static function set($_text, $_setting = [])
	{
		$default =
		[
			'sms'    => false,
			'active' => false,
		];

		if(!is_array($_setting))
		{
			$_setting = [];
		}

		$_setting = array_merge($default, $_setting);

		$active = $_setting['active'] ? 1 : 0;
		$sms    = $_setting['sms'] ? 1 : 0;

		if($active && !trim($_text))
		{
			\dash\notif::error(T_("Please set the message text"), 'text');
			return false;
		}

		if(mb_strlen($_text) > 200)
		{
			\dash\notif::error(T_("Please set the message text less than 200 character"), 'text');
			return false;
		}

		$file_text = "$active active\n$sms sms\n\n-----\n\n$_text";

		self::file($file_text, true);
		return true;

	}


	private static function file($_text = null, $_set = false)
	{
		$file = __DIR__. '/message.me.text';
		if(!is_file($file))
		{
			if($_set)
			{
				\dash\file::write($file, $_text);
			}
			else
			{
				return null;
			}
		}
		else
		{
			if($_set)
			{
				\dash\file::write($file, $_text);
			}
			else
			{
				return \dash\file::read($file);
			}
		}
	}
}
?>