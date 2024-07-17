<?php

namespace Modules\Main\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
//Kiskuta
class BMigrateSeed extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bcms:migrate-seed';

    /**
     * The console command description.
     */
    protected $description = 'Migrates all tables, and seeds them.';

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
        $this->call('db:wipe');
        $this->call('module:migrate');
        $this->call('module:seed');
        $this->call('bcms:create-super-admin');
        $this->info('Migrated and seeded successfully.');
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
