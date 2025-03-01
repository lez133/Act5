<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable(); // Nullable for social logins
            $table->string('email')->unique()->nullable(); // Nullable for accounts without emails
            $table->string('password')->nullable(); // Nullable for OAuth users
            $table->string('provider')->nullable(); // OAuth provider (e.g., google, facebook)
            $table->string('provider_id')->nullable(); // OAuth provider user ID
            $table->timestamps();
            $table->softDeletes(); // Optional: Enable soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
