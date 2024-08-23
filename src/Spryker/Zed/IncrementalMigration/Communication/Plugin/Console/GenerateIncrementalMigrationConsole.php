<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\IncrementalMigration\Communication\Plugin\Console;

use RuntimeException;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\IncrementalMigration\Communication\IncrementalMigrationCommunicationFactory getFactory()
 * @method \Spryker\Zed\IncrementalMigration\Persistence\IncrementalMigrationRepositoryInterface getRepository()
 */
class GenerateIncrementalMigrationConsole extends Console
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'incremental-migration:generate';

    /**
     * @var string
     */
    protected const COMMAND_DESCRIPTION = 'Create incremental migration template';

    /**
     * @return void
     */
    public function configure(): void
    {
        $this
            ->setName(static::COMMAND_NAME)
            ->setDescription(static::COMMAND_DESCRIPTION)
            ->addArgument('name', InputArgument::REQUIRED)
            ->addArgument('path', InputArgument::REQUIRED);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $migrationName = $this->generateMigrationName($input->getArgument('name'));
        $migrationPath = $input->getArgument('path');

        $fileContent = $this->getFactory()->createTwigEnvironment()->render(
            $this->getFactory()->getConfig()->getTemplateName(),
            [
                'className' => $migrationName,
            ],
        );

        $this->createDirectoryIfNotExists($migrationPath);

        $filePath = $migrationPath
            . DIRECTORY_SEPARATOR
            . $migrationName
            . '.php';

        file_put_contents($filePath, $fileContent);

        $this->success(sprintf('%s has been created!', $filePath));

        return self::CODE_SUCCESS;
    }

    /**
     * @param string $classNameArgument
     *
     * @return string
     */
    protected function generateMigrationName(string $classNameArgument): string
    {
        return 'Incremental_' . date('YmdHis') . '_' . $classNameArgument;
    }

    /**
     * @param string $directory
     *
     * @throws \RuntimeException
     *
     * @return void
     */
    public function createDirectoryIfNotExists(string $directory): void
    {
        if (is_dir($directory)) {
            return;
        }

        if (!mkdir($directory, 0775, true)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }
    }
}
