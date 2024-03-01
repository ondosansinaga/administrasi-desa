<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100)->nullable(false)->unique('users_username_unique');
            $table->string('password', 100)->nullable(false);
            $table->string('image_url')->nullable();
            $table->string('nik')->nullable(false)->unique('users_nik_unique');
            $table->string('name')->nullable(false);
            $table->string('birth_info')->nullable();
            $table->text('address')->nullable();
            $table->string('job_title')->nullable();
            $table->boolean('gender')->default(false);
            $table->timestamps();

            $table->unsignedBigInteger('role_id')->nullable(false);
            $table->foreign('role_id')->on('roles')->references('id');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->on('users')->references('id')->onDelete('set null');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->on('users')->references('id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
