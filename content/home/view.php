<?php
namespace content\home;

class view extends \mvc\view
{
	function config()
	{
		$this->data->bodyclass = 'unselectable vflex';
		// $this->include->js     = false;

		self::set_static_titles();
	}


	/**
	 * [pushState description]
	 * @return [type] [description]
	 */
	function pushState()
	{
		// if($this->module() !== 'home')
		// {
		// 	$this->data->display['mvc']     = "content/home/layout-xhr.html";
		// }
	}


	/**
	 * set title of static pages in project
	 */
	function set_static_titles()
	{
		$this->data->page['desc']  = $this->data->site['desc'];

		return;

		switch ($this->module())
		{
			case 'home':
				$this->data->page['title']   = $this->data->site['title']. ' - '. T_('Integrated Sales and Online Accounting');
				$this->data->page['special'] = true;
				break;


			case 'terms':
				$this->data->page['title'] = T_('Terms of Service Agreement');
				$this->data->page['desc']  = T_('Khadije acts upon international rules, depends on the countries receiving its services and renders its activities within this framework.');
				break;


			case 'privacy':
				$this->data->page['title'] = T_('Privacy Policy');
				$this->data->page['desc']  = T_('We wish to assure you that our main concern is to secure your privacy and protect your information against impermissible access.');
				break;


			case 'social-responsibility':
				$this->data->page['title'] = T_('Khadije Social Responsibility');
				$this->data->page['desc']  = T_('Social responsibility refers to our role in maintaining, caring about and helping our society, while having set as its goal a responsibility-centered enterprise along with wealth production.');
				break;


			case 'enterprise':
				$this->data->page['title'] = T_('Enterprise');
				$this->data->page['desc']  = T_('Have a headaches? We have soulutions. Be patient...');
				break;


			case 'changelog':
				$this->data->page['title'] = T_('Change log of Khadije');
				$this->data->page['desc']  = T_('We were born to do Best!'). ' ' . T_("We are Developers, please wait!");
				break;


			case 'help':
				switch ($this->child())
				{
					case 'faq':
						$this->data->page['title'] = T_('Frequently Asked Questions');
						$this->data->page['desc']  = T_('This FAQ provides answers to basic questions about Khadije.');
						break;

					default:
						$this->data->page['title'] = T_('Help Center');
						$this->data->page['desc']  = T_('Need HELP? Be patient...');
						break;
				}
				break;


			case 'benefits':
				$this->data->page['title'] = T_('Khadije benefits');
				$this->data->page['desc']  = T_('What can you do with Khadije?');
				break;


			case 'about':
				$this->data->page['title'] = T_('About our platform');
				$this->data->page['desc']  = $this->data->site['desc'];
				break;

			case 'logo':
				$this->data->page['title'] = T_('Khadije Logo');
				$this->data->page['desc']  = T_('Need know more about Khadije Logo? We are not choose our final logo yet!');
				break;

			case 'pricing':
				$this->data->page['title'] = T_('Plans and Pricing of Khadije');
				$this->data->page['desc']  = T_("Always know what you'll pay per month.") . ' ' . T_('Simple pricing');
				break;



			default:
				$this->data->page['title']   = $this->data->site['title']. ' - '. T_('Integrated Sales and Online Accounting');
				break;
		}
	}
}
?>