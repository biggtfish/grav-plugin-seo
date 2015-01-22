<?php

namespace Gertt\Grav\Seo\Metadata;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

class Facebook extends Plugin
{
	public static function getSubscribedEvents() {
		return [
			'onPageProcessed' => ['onPageProcessed', 0],
		];
	}

	public function onPageProcessed(Event $e)
	{
		$page = $e['page'];

		$available = [
			'page' => (array) $page->header(),
			'site' => $this->config->get('site')
		];

		$metadata = $page->metadata();

		if (empty($metadata['og:title']))
			$metadata['og:title'] = [ 'property' => 'og:title', 'content' => empty($available['page']['title']) ? $available['site']['title'] : $available['page']['title'] ];

		if (empty($metadata['og:description']))
			$metadata['og:description'] = [ 'property' => 'og:description', 'content' => $available['page']['metadata']['description'] ];

		$page->metadata($metadata);
	}


}