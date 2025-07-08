<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Schema\AbstractSchemaManager;

class DropAllViews extends Command
{
    protected $signature = 'drop:allviews';
    protected $description = 'Drop all views in all configured database connections';

    public function handle()
    {
        $connections = ['mysql', 'mysql_hrms', 'mysql_comlib'];

        foreach ($connections as $connection) {
            try {
                $this->info("Dropping views on connection: $connection");

                // Get the schema manager
                /** @var AbstractSchemaManager $schemaManager */
                $schemaManager = DB::connection($connection)->getDoctrineSchemaManager();
                $views = $schemaManager->listViews();

                foreach ($views as $view) {
                    $viewName = $view->getName();
                    DB::connection($connection)->statement("DROP VIEW IF EXISTS `$viewName`");
                    $this->line(" - Dropped view: $viewName");
                }

                $this->info("✅ Done with $connection.\n");
            } catch (\Throwable $e) {
                $this->error("❌ Error on connection $connection: " . $e->getMessage());
            }
        }
    }
}
