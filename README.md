# Incremental Migration Module
[![Latest Stable Version](https://poser.pugx.org/spryker/installer/v/stable.svg)](https://packagist.org/packages/vitaliiivanovspryker/incremental-migration)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.1-8892BF.svg)](https://php.net/)

Installer is responsible for managing the installment process of required database data.

## Installation

```
composer require vitaliiivanovspryker/incremental-migration
```

```
console propel:install
```

\Pyz\Zed\Console\ConsoleDependencyProvider::getConsoleCommands

```php
    new GenerateIncrementalMigrationConsole(),
    new MigrateIncrementalMigrationConsole(),
```

## Documentation

[Spryker Documentation](https://docs.spryker.com)

## Usage

```
console incremental-migration:generate FooMigration src/Pyz/Zed/Foo/Communication/Plugin/Migration
```


```php
namespace Pyz\Zed\IncrementalMigration;

use Spryker\Zed\IncrementalMigration\IncrementalMigrationDependencyProvider as SprykerIncrementalMigrationDependencyProvider;

class IncrementalMigrationDependencyProvider extends SprykerIncrementalMigrationDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\IncrementalMigration\Dependency\IncrementalMigrationPluginInterface>
     */
    protected function getIncrementalDataMigrations(): array
    {
        return [
            // new GeneratedIncrementalMigration(),
        ];
    }
}
```

```
console incremental-migration:migrate
```
