<?php

namespace Gertt\Grav\Seo;

use Grav\Common\Grav;
use Grav\Common\Plugin;

class Seo
{
	protected $plugin = null;
	protected $grav = null;
	protected $config = null;

	protected $optimize = [];

	function __construct(Plugin $plugin, Grav &$grav)
	{
		$this->plugin = $plugin;
		$this->grav = $grav;
		$this->config = $grav['config'];
	}

	public function getHooks()
	{
		$enable = [];

		$this->optimize['metadata'] = $this->config->get('plugins.seo.meta.optimize');

	    if ($this->optimize['metadata']) {
	    	$enable['onPageInitialized'] = ['onPageInitialized', 0];
	    }

	    return $enable;
	}

	public function onPageInitialized()
	{
		$available = [
			'page' => (array) $this->grav['page']->header(),
			'site' => $this->config->get('site')
		];

		$metadata = $this->grav['page']->metadata();

		if (empty($metadata['og:title']))
			$metadata['og:title'] = [ 'property' => 'og:title', 'content' => empty($available['page']['title']) ? $available['site']['title'] : $available['page']['title'] ];

		if (empty($metadata['og:description']))
			$metadata['og:description'] = [ 'property' => 'og:description', 'content' => $available['page']['metadata']['description'] ];

		$this->grav['page']->metadata($metadata);
	}
}

