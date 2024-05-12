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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('MembershipNumber')->nullable();
            $table->string('idNo')->nullable();
            $table->string('surNameName')->nullable();
            $table->string('firstName')->nullable();
            $table->string('secondName')->nullable();
            $table->string('memberStatus')->nullable();
            $table->string('emailAddress')->nullable();
            $table->string('mobilePhoneNumber');
            $table->date('expiryDate')->nullable();
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
        Schema::dropIfExists('members');
    }
};
