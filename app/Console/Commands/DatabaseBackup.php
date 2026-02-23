<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup {--clean : Clean old backups}';
    protected $description = 'Create a backup of the database';

    public function handle()
    {
        $this->info('Starting database backup...');

        try {
            // Create backups directory if it doesn't exist
            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            // Generate backup filename with timestamp
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $filepath = $backupPath . '/' . $filename;

            // Get all tables
            $tables = $this->getAllTables();

            // Open file for writing
            $handle = fopen($filepath, 'w');

            // Write header
            fwrite($handle, "-- Database Backup\n");
            fwrite($handle, "-- Generated: " . date('Y-m-d H:i:s') . "\n\n");
            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");

            // Backup each table
            foreach ($tables as $table) {
                $this->line("Backing up table: {$table}");
                $this->backupTable($handle, $table);
            }

            fwrite($handle, "\nSET FOREIGN_KEY_CHECKS=1;\n");
            fclose($handle);

            $size = filesize($filepath);
            $this->info("✅ Backup created successfully!");
            $this->info("📁 File: {$filename}");
            $this->info("💾 Size: " . $this->formatBytes($size));
            $this->info("📍 Location: {$filepath}");

            // Clean old backups if requested
            if ($this->option('clean')) {
                $this->cleanOldBackups($backupPath);
            }

            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Backup failed: " . $e->getMessage());
            return 1;
        }
    }

    protected function getAllTables()
    {
        $database = config('database.connections.mysql.database');
        $tables = DB::select("SHOW TABLES");
        $tableKey = "Tables_in_{$database}";

        return array_map(function ($table) use ($tableKey) {
            return $table->$tableKey;
        }, $tables);
    }

    protected function backupTable($handle, $table)
    {
        // Get CREATE TABLE statement
        $createTable = DB::select("SHOW CREATE TABLE `{$table}`")[0];
        fwrite($handle, "\n-- Table: {$table}\n");
        fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n");
        fwrite($handle, $createTable->{'Create Table'} . ";\n\n");

        // Get table data
        $rows = DB::table($table)->get();

        if ($rows->count() > 0) {
            fwrite($handle, "-- Data for table: {$table}\n");

            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    if (is_null($value)) {
                        return 'NULL';
                    }
                    return "'" . addslashes($value) . "'";
                }, (array) $row);

                $columns = array_keys((array) $row);
                $columnsList = '`' . implode('`, `', $columns) . '`';
                $valuesList = implode(', ', $values);

                fwrite($handle, "INSERT INTO `{$table}` ({$columnsList}) VALUES ({$valuesList});\n");
            }

            fwrite($handle, "\n");
        }
    }

    protected function cleanOldBackups($backupPath)
    {
        $this->info('Cleaning old backups...');

        $files = glob($backupPath . '/backup_*.sql');

        // Sort by modification time (newest first)
        usort($files, function ($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        // Keep only the last 7 backups
        $keepCount = 7;
        $deleted = 0;

        foreach (array_slice($files, $keepCount) as $file) {
            if (unlink($file)) {
                $deleted++;
                $this->line("🗑️  Deleted: " . basename($file));
            }
        }

        if ($deleted > 0) {
            $this->info("✅ Cleaned {$deleted} old backup(s)");
        } else {
            $this->info("ℹ️  No old backups to clean");
        }
    }

    protected function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
