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
        Schema::create('data_warga', function (Blueprint $table) {
           $table->id();
            $table->string('username', 100)->nullable(false)->unique('username');
            $table->string('password', 100)->nullable(false);
            $table->string('image_url')->nullable();
            $table->string('nik')->nullable(false)->unique('nik');
            $table->string('name')->nullable(true);    
            $table->string('birth_info')->nullable();
            $table->text('address')->nullable();
            $table->boolean('gender')->default(false);
            $table->timestamps();
            $table->enum('status_1', ['Kelahiran', 'Masuk', 'Keluar','Kematian'])->default('Kelahiran');
            $table->enum('status_2', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->enum('status_perkawinana', ['Kawin', 'Belum Kawin'])->default('Belum Kawin');
            $table->string('job_title')->nullable();
            $table->string('kewarganegaraan')->nullable();

             // Menambahkan foreign key untuk relasi dengan tabel users
             $table->unsignedBigInteger('user_id')->nullable();
             $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
 
             $table->unsignedBigInteger('role_id')->nullable(false);
             $table->foreign('role_id')->references('id')->on('roles');
 
             $table->unsignedBigInteger('created_by')->nullable();
             $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
 
             $table->unsignedBigInteger('updated_by')->nullable();
             $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
         
         

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
