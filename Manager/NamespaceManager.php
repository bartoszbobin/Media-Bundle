<?php
namespace Bobin\MediaBundle\Manager;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Bobin\MediaBundle\Data\MediaNamespace;

class NamespaceManager {

	/**
	 * @var Symfony\Component\DependencyInjection\ContainerInterface 
	 */
	private $container;

	public function __construct(Container $container) {
		$this->container = $container;
	}

	/**
	 * @param string $namespace
	 * @return array
	 */
	private function getConfigForNamespace($namespace) {
		$namespaces = $this->container->getParameter('bobin_media.namespaces');
		if (empty($namespaces[$namespace])) {
			throw new \Exception('Can\'t found config for given namespaces: `'.$namespace.'`');
		}
		return $namespaces[$namespace];
	}

	/**
	 * @param string $namespace
	 * @return \Bobin\MediaBundle\Data\MediaNamespace
	 */
	public function getMediaNamespace($namespace) {
		$config = $this->getConfigForNamespace($namespace);
		return new MediaNamespace($config);
	}
}