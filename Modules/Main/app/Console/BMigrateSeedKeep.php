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
        $this->call('module:migrate-rollback');
        $this->call('module:migrate');
        $this->call('module:seed-keep');
        $this->info('Migrated and seeded and keep successfully.');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
