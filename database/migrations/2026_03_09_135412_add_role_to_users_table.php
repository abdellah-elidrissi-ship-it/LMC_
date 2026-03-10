<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['super_admin', 'chef_projet', 'consultant'])
              ->default('consultant')
              ->after('email');
        $table->foreignId('consultant_id')
              ->nullable()
              ->constrained('consultants')
              ->nullOnDelete()
              ->after('role');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['role', 'consultant_id']);
    });
}
};
