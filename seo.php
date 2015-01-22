<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use Gertt\Grav\Seo\Seo;

class SeoPlugin extends Plugin
{
	protected $seo = null;

	public static function getSubscribedEvents() {
		return [
			'onPluginsInitialized' => ['onPluginsInitialized', 0],
		];
	}

	public function onPluginsInitialized()
	{
		$autoload = __DIR__ . '/vendor/autoload.php';
		
		if (!is_file($autoload)) {
			$this->grav['logger']->error('SEO Plugin failed to load. Composer dependencies not met.');
		}

		require_once $autoload;

		$this->seo = new Seo($this, $this->grav);

		$hooks = $this->seo->getHooks();

		if ( ! empty($hooks) )
			$this->enable($hooks);
	}

	public function onPageInitialized()
	{
		$this->seo->onPageInitialized();
	}

}