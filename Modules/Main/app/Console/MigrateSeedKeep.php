<?php

namespace Modules\Main\Console;

use Illuminate\Console\Command;
use Nwidart\Modules\Commands\Database\SeedCommand;
use Nwidart\Modules\Module;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
class MigrateSeedKeep extends SeedCommand
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'module:seed-keep';

    /**
     * The console command description.
     */
    public function moduleSeed(Module $module)
    {
        $seeders = [];
        $name = $module->getName();
        // Define the path to the keep-seed directory within the module's database directory
        $keepSeedPath = module_path($name) . '/database/KeepSeeders/';

        // Scan the keep-seed directory for PHP files
        $seederFiles = glob($keepSeedPath . '*.php');

        foreach ($seederFiles as $file) {
            // Extract the class name from the file name
            $className = basename($file, '.php');
            // Construct the full class name assuming PSR-4 autoloading based on the module structure
            $fullClassName = "Modules\\{$name}\\Database\\KeepSeed\\{$className}";

            if (class_exists($fullClassName)) {
                $seeders[] = $fullClassName;
            }
        }

        if (count($seeders) > 0) {
            array_walk($seeders, [$this, 'dbSeed']);
            $this->info("Module [$name] seeded with keep-seed.");
        } else {
            $this->error("No seeders found in the keep-seed directory for Module [$name].");
        }
    }
}
