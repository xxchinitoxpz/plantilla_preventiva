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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 200);
            $table->string('document_number', 20);
            $table->char('phone', 9);
            $table->string('email', 200);
            $table->date('birthdate');
            $table->string('sex', 10);
            $table->string('nationality', 30);
            $table->string('address', 100);
            $table->string('role', 30);
            $table->char('state', 1);
            $table->unsignedBigInteger('document_type_id')->nullable();
            $table->foreign('document_type_id')
                ->references('id')->on('documents_types')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
