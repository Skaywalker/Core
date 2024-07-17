<?php

namespace Modules\User\Database\KeepSeeders;

use function bcrypt;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermisionKeepSeeder extends Seeder
{
    protected $table="permissions";
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        if (Schema::hasTable('old_'.$this->table)) {
            $oldItems = DB::table('old_'.$this->table)->get()->toArray();
            $dataSet = [];

            foreach ($oldItems as $item) {
                $record = [];
                foreach ($item as $column_name => $value) {
                    $record[$column_name] = $value;
                }
                $dataSet[] = $record;
            }

            DB::table($this->table)->insert($dataSet);
            Schema::dropIfExists('old_'.$this->table);
        }
    }
}
