<?php

namespace Gertt\Grav\Seo;

use Grav\Common\Plugin;

class Seo extends Plugin
{
	protected $plugin = null;
	protected $grav = null;
	protected $config = null;

	protected $optimize = [];

	public function init()
	{
	    if ($this->config->get('plugins.seo.meta.optimize')) {
			$this->grav['events']->addSubscriber(new Metadata\Facebook($this->grav, $this->config));
	    }

	    if ($this->config->get('plugins.seo.analytics.insights.enabled')) {
			$this->grav['events']->addSubscriber(new Analytics\FacebookInsights($this->grav, $this->config));
	    }
	}
}

