<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\IncrementalMigration;

use Spryker\Service\Container\Container;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;

class IncrementalMigrationDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const INCREMENTAL_MIGRATIONS = 'INCREMENTAL_MIGRATIONS';

    /**
     * @param \Spryker\Service\Container\Container $container
     *
     * @return \Spryker\Service\Container\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addIncrementalDataMigrations($container);

        return $container;
    }

    /**
     * @param \Spryker\Service\Container\Container $container
     *
     * @return \Spryker\Service\Container\Container
     */
    protected function addIncrementalDataMigrations(Container $container): Container
    {
        $container->set(static::INCREMENTAL_DATA_MIGRATIONS, function (Container $container) {
            return $this->getIncrementalDataMigrations();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\IncrementalMigration\Dependency\IncrementalMigrationPluginInterface>
     */
    protected function getIncrementalDataMigrations(): array
    {
        return [];
    }
}
