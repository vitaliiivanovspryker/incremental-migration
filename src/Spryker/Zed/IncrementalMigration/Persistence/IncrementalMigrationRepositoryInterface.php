<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\IncrementalMigration\Persistence;

interface IncrementalMigrationRepositoryInterface
{
    /**
     * @return array<string>
     */
    public function getExecutedMigrations(): array;

    /**
     * @return int
     */
    public function getLastBatch(): int;
}
