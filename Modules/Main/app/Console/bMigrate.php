<?php

namespace Modules\Main\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
class bMigrate extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bcms:migrate';

    /**
     * The console command description.
     */
    protected $description = 'Bihcsay CMS Migrate all tables.';

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
    }

    /**
     * Get the console command arguments.
     */
}
