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
        Schema::table('product_histories', function (Blueprint $table) {
            $table->string("people_name")->nullable()->change();
            $table->string("people_phone")->nullable()->change();
            $table->string("people_email")->nullable()->change();
            $table->integer("assignment_quantity")->nullable()->change();
            $table->dateTime("assign_date")->nullable()->change();
            $table->dateTime("devolution_date")->nullable()->change();
            $table->text("observation")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_histories', function (Blueprint $table) {
            $table->string("people_name");
            $table->string("people_phone");
            $table->string("people_email");
            $table->integer("assignment_quantity");
            $table->dateTime("assign_date");
            $table->dateTime("devolution_date");
            $table->text("observation");
        });
    }
};
