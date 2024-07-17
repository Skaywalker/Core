<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('name');
            $table->string('label');
            $table->timestamps();
        });
        Schema::create('permissions',function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::create('role_user', function (Blueprint $table) {
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
        Schema::table('permission_roles', function (Blueprint $table) {
            $table->dropForeign(['permission_id']);
            $table->dropForeign(['role_id']);
        });
        Schema::rename('permission_roles', 'old_permission_roles');
        Schema::table('old_permission_roles',function (Blueprint $table){
            $table->foreign('permission_id')->references('id')->on('old_permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('old_roles')->onDelete('cascade');
        });
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['role_id']);
        });
        Schema::rename('role_user', 'old_role_user');
        Schema::table('old_role_user',function (Blueprint $table){
            $table->foreign('user_id')->references('id')->on('old_users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('old_roles')->onDelete('cascade');
        });
        Schema::dropIfExists('permission_roles');
        Schema::dropIfExists('role_user');

    }
};
