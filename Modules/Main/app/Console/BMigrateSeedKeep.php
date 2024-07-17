<?php

namespace Modules\Main\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
//Kiskuta
class BMigrateSeedKeep extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bcms:migrate-seed-keep';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->warn('Foreign key checks are off.');
        $this->info('Migrate-rollback start');
        $this->call('module:migrate-rollback');
        $this->info('Migrate-rollback end');
        $this->info('Migrate start');
        $this->call('module:migrate');
        $this->info('Migrate end');
        $this->info('Seed-keep start');
        $this->call('module:seed-keep');
        $this->info('Seed-keep end');
        $this->info('Migrated and seeded and keep successfully.');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->info('Foreign key checks are on.');

    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [];
    }
}
