<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\IncrementalMigration;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class IncrementalMigrationConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getRenderTemplatePath(): string
    {
        return __DIR__
            . DIRECTORY_SEPARATOR . 'Presentation'
            . DIRECTORY_SEPARATOR . 'MigrationTemplate';
    }

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return 'incremental_migration.php.twig';
    }

    /**
     * @return string
     */
    public function getIncrementalDataMigrationDirectory(): string
    {
        return __DIR__
        . DIRECTORY_SEPARATOR . 'Communication'
        . DIRECTORY_SEPARATOR . 'Plugin'
        . DIRECTORY_SEPARATOR . 'Migration';
    }
}
