<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropAllTables extends Command
{
    protected $signature = 'drop:alltables';
    protected $description = 'Drop all tables from all configured databases';

    public function handle()
    {
        $connections = ['mysql', 'mysql_hrms', 'mysql_comlib'];

        foreach ($connections as $connection) {
            try {
                $databaseName = DB::connection($connection)->getDatabaseName();
                $this->info("Dropping tables in database: {$databaseName} ({$connection})");

                $tables = DB::connection($connection)->select('SHOW TABLES');

                // Determine correct key
                $key = "Tables_in_{$databaseName}";
                DB::connection($connection)->statement('SET FOREIGN_KEY_CHECKS=0;');
                foreach ($tables as $table) {
                    $tableName = $table->$key;
                    Schema::connection($connection)->dropIfExists($tableName);
                    $this->line("- Dropped table: {$tableName}");
                }
                DB::connection($connection)->statement('SET FOREIGN_KEY_CHECKS=1;');
            } catch (\Exception $e) {
                $this->error("Error on connection {$connection}: " . $e->getMessage());
            }
        }
    }
}
