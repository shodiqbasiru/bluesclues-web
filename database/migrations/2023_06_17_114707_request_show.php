<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('show_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('email');
            $table->timestamp('date');
            $table->string('whatsapp');
            $table->string('eventname');
            $table->string('location');
            $table->text('notes')->nullable();;
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('show_requests');
    }
};
