<?php

namespace Modules\User\Database\KeepSeeders;

use Dflydev\DotAccessData\Data;
use Illuminate\Database\Seeder;

class UserDatabaseKeepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserKeepSeeder::class,
            PermisionKeepSeeder::class,
        ]);
    }
}
