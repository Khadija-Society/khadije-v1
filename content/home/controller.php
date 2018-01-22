<?php
namespace content\home;

class controller extends \mvc\controller
{

	/**
	 * the static page to not run any query
	 * and brand black list
	 * @var        array
	 */
	public static  $static_pages =
	[
		'benefits',
		'pricing',
		'khadije',
		'help',
		'admin',
		'enter',
		'about',
		'social-responsibility',
		'terms',
		'privacy',
		'changelog',
		'logo',
		'contact',
		'api',
		// brand black list
		'branch',
		'team',
		'member',
		'add',
		'edit',
		'delete',
		'user',
		'hours',
		'report',
		'last',
		'daily',
		'account',
		'for',
		'files',

	];

	// for routing check
	function ready()
	{

		$this->post('donate')->ALL();

		// if have display return false
		if($this->display_name !== null)
		{
			return false;
		}
		// if on homepage return false
		$url = \lib\router::get_url();
		if(!$url)
		{
			return false;
		}
		// if the url in static page [and black list] return
		if(in_array($url, self::$static_pages))
		{
			return;
		}

	}
}
?>