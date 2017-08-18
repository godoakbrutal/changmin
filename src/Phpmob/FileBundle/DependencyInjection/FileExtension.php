<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpmob\FileBundle\DependencyInjection;

use Phpmob\FileBundle\FileBundle;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class FileExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $this->registerResources('phpmob', $config['driver'], [], $container);

        $container->setParameter('phpmob.filters', $config['filters']);
        $container->setParameter('phpmob.uploader.filesystem', 'phpmob_filesystem_' . $config['filesystem']);
        $container->setParameter('phpmob.uploader.directory', $config['directory']);
        $container->setParameter('phpmob.uploader.dbal', $config['filesystem'] === 'dbal');
        $container->setParameter('phpmob.uploader.dbal_connection', $config['dbal_connection']);
        $container->setParameter('phpmob.uploader.dbal_table', $config['dbal_table']);
        $container->setParameter('phpmob.imagine.filter', $config['imagine']['filter']);
        $container->setParameter('phpmob.imagine.quality', $config['imagine']['quality']);

        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'phpmob_file';
    }
}
