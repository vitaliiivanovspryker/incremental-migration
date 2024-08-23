<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\IncrementalMigration\Communication;

use Spryker\Zed\IncrementalMigration\IncrementalMigrationDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * @method \Spryker\Zed\IncrementalMigration\IncrementalMigrationConfig getConfig()
 * @method \Spryker\Zed\IncrementalMigration\Persistence\IncrementalMigrationRepositoryInterface getRepository()
 */
class IncrementalMigrationCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Twig\Environment
     */
    public function createTwigEnvironment(): Environment
    {
        return new Environment(
            $this->createFilesystemLoader(),
        );
    }

    /**
     * @return array<\Spryker\Zed\IncrementalMigration\Dependency\IncrementalMigrationPluginInterface>
     */
    public function getIncrementalDataMigrations(): array
    {
        return $this->getProvidedDependency(IncrementalMigrationDependencyProvider::INCREMENTAL_DATA_MIGRATIONS);
    }

    /**
     * @return \Twig\Loader\FilesystemLoader
     */
    protected function createFilesystemLoader(): FilesystemLoader
    {
        return new FilesystemLoader($this->getConfig()->getRenderTemplatePath());
    }
}
