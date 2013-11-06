<?php

namespace Bobin\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bobin_media');
		
		$rootNode
			->requiresAtLeastOneElement()
            ->useAttributeAsKey('namespace')
				->prototype("array")
					->children()
						->scalarNode("path")->defaultValue('/path/to/dir/')->end()
					->end()
					->children()
						->arrayNode("sizes")
							->prototype("array")
							->children()
								->integerNode("width")->isRequired()->end()
								->integerNode("height")->isRequired()->end()
								->booleanNode("fit_big_to_size")->defaultFalse()->end()
								->booleanNode("resize_small_to_size")->defaultTrue()->end()
							->end()
						->end()
						->end()
					->end()
				->end()
            ->end();
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
