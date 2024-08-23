<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\IncrementalMigration\Persistence;

use Orm\Zed\IncrementalMigration\Persistence\Map\SpyIncrementalMigrationTableMap;
use Orm\Zed\IncrementalMigration\Persistence\SpyIncrementalMigrationQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

class IncrementalMigrationRepository extends AbstractRepository implements IncrementalMigrationRepositoryInterface
{
    /**
     * @return array<string>
     */
    public function getExecutedMigrations(): array
    {
        return SpyIncrementalMigrationQuery::create()
            ->orderByMigration()
            ->select([SpyIncrementalMigrationTableMap::COL_MIGRATION])
            ->find()
            ->getData();
    }

    /**
     * @return int
     */
    public function getLastBatch(): int
    {
        $lastBath = SpyIncrementalMigrationQuery::create()
            ->orderByBatch()
            ->select([SpyIncrementalMigrationTableMap::COL_BATCH])
            ->findOne();

        return $lastBath ?? 0;
    }
}
