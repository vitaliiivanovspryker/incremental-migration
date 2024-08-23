<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\IncrementalMigration\Communication\Plugin\Console;

use Orm\Zed\IncrementalMigration\Persistence\SpyIncrementalMigration;
use Spryker\Zed\IncrementalMigration\Dependency\IncrementalMigrationPluginInterface;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\IncrementalMigration\Communication\IncrementalMigrationCommunicationFactory getFactory()
 * @method \Spryker\Zed\IncrementalMigration\Persistence\IncrementalMigrationRepositoryInterface getRepository()
 */
class MigrateIncrementalMigrationConsole extends Console
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'incremental-migration:migrate';

    /**
     * @var string
     */
    protected const COMMAND_DESCRIPTION = 'Migrate incremental migration';

    /**
     * @var string
     */
    protected const OPT_DRY_RUN = 'dry-run';

    /**
     * @return void
     */
    public function configure(): void
    {
        $this
            ->setName(static::COMMAND_NAME)
            ->setDescription(static::COMMAND_DESCRIPTION)
            ->addOption(self::OPT_DRY_RUN, null, InputOption::VALUE_NONE, 'Do not execute migrations');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dryRun = $input->getOption(self::OPT_DRY_RUN);

        $migrations = $this->getFactory()->getIncrementalDataMigrations();

        $migrationNames = array_map(function (IncrementalMigrationPluginInterface $migration) {
            return $this->extractMigrationName(get_class($migration));
        }, $migrations);

        $executedMigrations = $this->getRepository()->getExecutedMigrations();

        $pendingMigrationNames = array_diff($migrationNames, $executedMigrations);

        $this->info('There are the next pending incremental data migration to be executed:');
        foreach ($pendingMigrationNames as $pendingMigrationName) {
            $this->info($pendingMigrationName);
        }

        if ($dryRun === true) {
            return self::CODE_SUCCESS;
        }

        $pendingMigrations = array_filter($migrations, function (IncrementalMigrationPluginInterface $migration) use ($pendingMigrationNames) {
            return in_array($this->extractMigrationName(get_class($migration)), $pendingMigrationNames, true);
        });

        $lastBatch = $this->getRepository()->getLastBatch();
        $batch = ++$lastBatch;

        foreach ($pendingMigrations as $pendingMigration) {
            if ($pendingMigration->isApplicable() === false) {
                continue;
            }
            $pendingMigration->execute($output);
            $this->acknowledgeMigration(
                $this->extractMigrationName(get_class($pendingMigration)),
                $batch,
            );
        }

        $this->success(sprintf('Executed %s incremental data migrations!', count($pendingMigrationNames)));

        return self::CODE_SUCCESS;
    }

    /**
     * @param string $name
     * @param int $batch
     *
     * @return void
     */
    protected function acknowledgeMigration(string $name, int $batch): void
    {
        $migrationEntity = new SpyIncrementalMigration();
        $migrationEntity->setMigration($name);
        $migrationEntity->setBatch($batch);

        $migrationEntity->save();
    }

    /**
     * @param string $className
     *
     * @return string
     */
    protected function extractMigrationName(string $className): string
    {
        preg_match('/Incremental_\d+_\w+$/', $className, $matches);

        return $matches[0] ?? '';
    }
}
