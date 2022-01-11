<?php
namespace content_a\protection\access;


class controller extends \content_protection\agentoccasion\access\controller
{
	public static function routing()
	{
		\content_a\protection\main::check();

		parent::routing();

	}
}
?>