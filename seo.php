<?php
namespace Grav\Plugin;

use Grav\Common\Page\Collection;
use Grav\Common\Plugin;
use Grav\Common\Uri;
use Grav\Common\Taxonomy;

class SeoPlugin extends Plugin
{
	protected $optimize = [
		'metadata' => false
	];

	public static function getSubscribedEvents() {
		return [
			'onPluginsInitialized' => ['onPluginsInitialized', 0],
		];
	}

	public function onPluginsInitialized()
	{
	    $this->optimize['metadata'] = $this->config->get('plugins.seo.meta.optimize');

	    if ($this->optimize['metadata']) {
	        $this->enable([
	            'onPageInitialized' => ['onPageInitialized', 0]
	        ]);
	    }
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

		$metadata = $this->grav['page']->metadata($metadata);
	}

}