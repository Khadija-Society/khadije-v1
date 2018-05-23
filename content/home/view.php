<?php
namespace content\home;

class view
{
	public static function config()
	{
		if(\dash\request::get('fixallbirthdate') && \dash\permission::supervisor())
		{
			self::fixallbirthdate();
		}

		\dash\data::bodyclass('unselectable');

		self::set_static_titles();

		$url = root. 'public_html/files/data/staticvar.txt';

		$result = @\dash\file::read($url);

		$temp            = [];
		$temp['qom']     = 16000;
		$temp['mashhad'] = 2000;
		$temp['karbala'] = 110;

		if(is_string($result))
		{
			$result          = explode("\n", $result);
			$temp['qom']     = isset($result[0]) ? $result[0] : null;
			$temp['mashhad'] = isset($result[1]) ? $result[1] : null;
			$temp['karbala'] = isset($result[2]) ? $result[2] : null;
		}
		\dash\data::staticvar($temp);
	}


	/**
	 * set title of static pages in project
	 */
	private static function set_static_titles()
	{
		\dash\data::page_desc(\dash\data::site_desc());

		// return;

		switch (\dash\url::module())
		{
			case '':
			case null:
				\dash\data::page_title(\dash\data::site_title(). ' | '. \dash\data::site_desc());
				\dash\data::page_special(true);
				break;


			case 'faq':
				\dash\data::page_title(T_('Frequently Asked Questions'));
				\dash\data::page_desc(T_('This FAQ provides answers to basic questions about Khadije.'));
				break;


			case 'mission':
				\dash\data::page_title(T_('Our missions'));
				// \dash\data::page_desc(\dash\data::site_desc());
				break;

			case 'vision':
				\dash\data::page_title(T_('Vision'));
				// \dash\data::page_desc(\dash\data::site_desc());
				break;

			case 'honors':
				\dash\data::page_title(T_('Our honors'));
				// \dash\data::page_desc(\dash\data::site_desc());
				break;

			case 'certificate':
				\dash\data::page_title(T_('Our certificates'));
				// \dash\data::page_desc(\dash\data::site_desc());
				break;

			case 'about':
				\dash\data::page_title(T_('About our charity'));
				// \dash\data::page_desc(\dash\data::site_desc());
				break;

			case 'mahdi-imani':
				\dash\data::page_title(T_('Shahid Mahdi Imani'));
				\dash\data::page_desc('وصیت نامه شهید مدافع حرم، مهدی ایمانی');
				break;

			default:

				break;
		}
	}



	public static function fixallbirthdate()
	{
		$query = "SELECT users.id, users.birthday FROM users where users.birthday is not null";
		$result = \dash\db::get($query, ['id', 'birthday']);
		$update = [];
		foreach ($result as $key => $value)
		{
			$new_birthdate = \dash\date::birthdate($value);
			if(!$new_birthdate)
			{
				$update[] = "UPDATE users SET users.birthday = NULL WHERE users.id = $key ";
			}
			else
			{
				$update[] = "UPDATE users SET users.birthday = '$new_birthdate' WHERE users.id = $key ";
			}

		}
		if(!empty($update))
		{
			\dash\db::query(implode($update, " ; "), true, ['multi_query' => true]);

		}
		echo count($update). " birthday changed";
		\dash\code::exit();

	}
}
?>