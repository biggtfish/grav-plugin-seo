<?php

namespace Gertt\Grav\Seo\Analytics;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

class FacebookInsights extends Plugin
{
	public static function getSubscribedEvents() {
		return [
			'onPageProcessed' => ['onPageProcessed', 0],
		];
	}

	public function onPageProcessed(Event $e)
	{
		$page = $e['page'];
		
		// @todo does not work, bug?
		 // if ( ! $page->home() )
			// return;

		$metadata = $page->metadata();

		if ( ! empty($metadata['og:app_id']) || ! empty($metadata['og:admins']) ) {
			$this->grav['logger']->warning('SEO plugin can\'t set Facebook Insight parameters because they are already in the metadata of your homepage.');

			return;
		}

		$property = $this->config->get('plugins.seo.analytics.insights.type') === 'app' ? 'fb:app_id' : 'fb:admins';
		$content = $this->config->get('plugins.seo.analytics.insights.id');

		$metadata[$property] = [ 'property' => $property, 'content' => $content ];

		$page->metadata($metadata);
	}


}