<?php
namespace content_cp\nationalcode\import;


class model
{
	public static function post()
	{
		self::upload_traveled('qom');
		self::upload_traveled('karbala');
		self::upload_traveled('mashhad');
		\dash\notif::ok(T_("Opertation complete"));
		\dash\redirect::pwd();

	}


	public static function upload_traveled($_city)
	{
		if($file = \dash\request::files($_city))
		{
			if(isset($file['tmp_name']))
			{
				$file_detail = file_get_contents($file['tmp_name']);
				$split       = explode("\n", $file_detail);
				$query       = [];
				$inserted    = [];
				$duplicate   = 0;

				foreach ($split as $key => $value)
				{
					$value = preg_replace("/\,|\'|\"|\,|\;\`/", '', $value);
					$value = \dash\utility\convert::to_en_number($value);
					if($value && is_numeric($value) && mb_strlen($value) === 10 && \dash\utility\filter::nationalcode($value))
					{
						if(in_array($value, $inserted))
						{
							$duplicate++;
						}
						else
						{
							$inserted[] = $value;
							$query[] =" INSERT INTO nationalcodes SET nationalcodes.nationalcode = '$value', nationalcodes.$_city = 1 ON DUPLICATE KEY UPDATE  nationalcodes.$_city = IF(nationalcodes.$_city IS NULL OR nationalcodes.$_city = '', 1, nationalcodes.$_city + 1) ";
						}
					}
				}

				if(empty($query))
				{
					\dash\notif::error(T_("No valid national code founded in your list"));
					return false;
				}

				$query = implode(";", $query);
				\dash\db::query($query, true, ['multi_query' => true]);

				\dash\notif::ok(T_("Travel this nationalcode to :city saved", ['city' => T_($_city)]));

			}
		}
	}
}
?>
