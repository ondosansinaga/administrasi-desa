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
        Schema::create('request_letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('letter_id')->nullable(false);
            $table->integer('status')->nullable(false);
            $table->string('doc_url')->nullable();
            $table->date('request_date')->nullable(false);
            $table->date('status_date')->nullable(false);
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');

            $table->foreign('letter_id')->on('letters')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_letters');
    }
};
