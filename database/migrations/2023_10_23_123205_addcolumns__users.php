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
        Schema::table('users', function (Blueprint $table) {
            $table->string('roles')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('hobbies')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('roles');
            $table->dropColumn('contact_number');
            $table->dropColumn('hobbies');
            $table->dropColumn('address');
            $table->dropColumn('city');
        });
    }
};
