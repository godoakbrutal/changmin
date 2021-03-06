<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\MediaBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('phpmob_media');

        $this->addImageFiltersSection($rootNode);
        $this->addImagineSection($rootNode);

        $rootNode
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
                ->scalarNode('filesystem')->defaultValue('local')->end()
                ->scalarNode('directory')->defaultValue('%kernel.root_dir%/../var/media')->end()
                ->scalarNode('dbal_connection')->defaultValue('default')->end()
                ->scalarNode('dbal_table')->defaultValue('phpmob_files')->end()
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addImageFiltersSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('filters')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('code')->cannotBeEmpty()->end()
                                ->scalarNode('label')->cannotBeEmpty()->end()
                                ->scalarNode('filter')->defaultNull()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addImagineSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('imagine')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('filter')->defaultValue('phpmob_imagine')->end()
                        ->scalarNode('quality')->defaultValue(100)->end()
                        ->scalarNode('data_loader')->defaultValue(null)->end()
                        ->scalarNode('form_default_image')->defaultValue('/bundles/phpmobmedia/img/changmin-100.png')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
