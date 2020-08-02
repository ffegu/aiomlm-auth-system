<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('city')->nullable();
            $table->integer('pin')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('counrty')->nullable();
            $table->string('address')->nullable();
            $table->integer('phonepe')->nullable();
            $table->integer('gpay')->nullable();
            $table->integer('paytm')->nullable();
            $table->string('paypal')->nullable();
            $table->string('cashapp')->nullable();
            $table->string('applepay')->nullable();
            $table->string('venmo')->nullable();
            $table->string('btc_address')->nullable();
            $table->integer('bank_ac_no')->nullable();
            $table->string('bank_ac_holder')->nullable();
            $table->string('bank_ac_ifsc')->nullable();
            $table->string('bank_ac_branch')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('pan_name')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->string('dob')->nullable();
            $table->string('gstin')->nullable();
            $table->string('tax_no')->nullable();
            $table->string('id_proof_pic')->nullable();
            $table->string('address_proof_pic')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
