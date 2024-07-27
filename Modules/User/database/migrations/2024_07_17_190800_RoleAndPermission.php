<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table){
            $table->id();
            $table->string('slug')->unique();
            $table->string('label');
            $table->timestamps();
        });
        Schema::create('permissions',function (Blueprint $table){
            $table->id();
            $table->string('slug')->unique();
            $table->string('label');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::create('roles_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->primary(['user_id', 'role_id']);
        });
        Schema::create('permission_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
             $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
             $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

      if (Schema::hasTable('permission_roles')&&DB::table('permission_roles')->count()) {
            Schema::dropIfExists('old_permission_roles');
            Schema::rename('permission_roles', 'old_permission_roles');
      }
        Schema::dropIfExists('permission_roles');
        if (Schema::hasTable('permissions')&&DB::table('permissions')->count()) {
            Schema::dropIfExists('old_permissions');
            Schema::rename('permissions', 'old_permissions');
        }
        Schema::dropIfExists('permissions');
        if (Schema::hasTable('roles_user')&&DB::table('roles_user')->count()) {
            Schema::dropIfExists('old_roles_user');
            Schema::rename('roles_user', 'old_roles_user');
        }
        Schema::dropIfExists('roles_user');

        if (Schema::hasTable('roles')&&DB::table('roles')->count()) {
            Schema::dropIfExists('old_roles');
            Schema::rename('roles', 'old_roles');
        }
        Schema::dropIfExists('roles');
    }

};
