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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('enname')->nullable();
            $table->string('username')->nullable();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('cell')->nullable();
            $table->string('role')->nullable();
            $table->string('status')->nullable();
            $table->string('activation_key')->nullable();
            $table->string('code')->nullable();
            $table->string('otp')->nullable();
            $table->integer('logerCount')->nullable();
            $table->integer('sl')->nullable();
            $table->integer('trans_id')->nullable();
            $table->dateTime('trans_date')->nullable();
            $table->integer('dtrans_id')->nullable();
            $table->dateTime('dtrans_date')->nullable();
            $table->integer('challanid')->nullable();
            $table->string('ipn_txid')->nullable();
            $table->string('amountFor')->nullable();
            $table->timestamps();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
