<?php

namespace DigitalWheat\Shopify;

use Illuminate\Console\Command;

class ShopifyTableCommand extends Command
{
    protected $name = 'shopify:table';

    protected $description = 'Create a migration for the Shopify database columns';

    public function fire()
    {
        file_put_contents($this->getMigrationPath(), $this->getMigrationStub());

        $this->info('Migration created successfully!');

        $this->laravel['composer']->dumpAutoloads();
    }

    protected function getMigrationPath()
    {
        $migrationCreator = $this->laravel['migration.creator'];

        return $migrationCreator->create('add_shopify_columns', "{$this->laravel['path.database']}/migrations");
    }

    protected function getMigrationStub()
    {
        return file_get_contents(__DIR__.'/migration.stub');
    }
}