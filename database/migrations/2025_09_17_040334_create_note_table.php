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
        Schema::create('note', function (Blueprint $table) {
            $table->id(); // SERIAL PRIMARY KEY
            $table->unsignedBigInteger('Id_Cliente');
            $table->string('Titulo', 150)->nullable();
            $table->string('Note', 500);
            $table->timestamp('Fecha')->useCurrent();

            // Foreign Key
            $table->foreign('Id_Cliente')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // opcional



            // users
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });

            // profiles (dependiente)
            Schema::create('profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('bio');
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note');
    }
};
