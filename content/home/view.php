<?php
namespace content\home;

class view extends \mvc\view
{
	function config()
	{
		$this->data->bodyclass = 'unselectable';
		// $this->include->js     = false;

		self::set_static_titles();

		$url = root. 'public_html/files/data/staticvar.txt';

		$result = @\lib\utility\file::read($url);

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
		$this->data->staticvar = $temp;

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

		// return;

		switch ($this->module())
		{
			case 'home':
				$this->data->page['title'] = $this->data->site['title']. ' | '. $this->data->site['desc'];
				$this->data->page['special'] = true;
				break;


			case 'faq':
				$this->data->page['title'] = T_('Frequently Asked Questions');
				$this->data->page['desc']  = T_('This FAQ provides answers to basic questions about Khadije.');
				break;


			case 'mission':
				$this->data->page['title'] = T_('Our missions');
				// $this->data->page['desc']  = $this->data->site['desc'];
				break;

			case 'vision':
				$this->data->page['title'] = T_('Vision');
				// $this->data->page['desc']  = $this->data->site['desc'];
				break;

			case 'honors':
				$this->data->page['title'] = T_('Our honors');
				// $this->data->page['desc']  = $this->data->site['desc'];
				break;

			case 'certificate':
				$this->data->page['title'] = T_('Our certificates');
				// $this->data->page['desc']  = $this->data->site['desc'];
				break;

			case 'about':
				$this->data->page['title'] = T_('About our charity');
				// $this->data->page['desc']  = $this->data->site['desc'];
				break;

			case 'mahdi-imani':
				$this->data->page['title'] = T_('Shahid Mahdi Imani');
				$this->data->page['desc']  = 'وصیت نامه شهید مدافع حرم، مهدی ایمانی';
				break;

			default:
				// $this->data->page['title']   = $this->data->site['title'];
				break;
		}
	}
}
?>