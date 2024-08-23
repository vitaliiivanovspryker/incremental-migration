<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\IncrementalMigration\Dependency;

use Symfony\Component\Console\Output\OutputInterface;

interface IncrementalMigrationPluginInterface
{
    /**
     * @return bool
     */
    public function isApplicable(): bool;

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    public function execute(OutputInterface $output): void;
}
