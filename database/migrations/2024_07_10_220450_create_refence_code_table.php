<?php

use App\Models\Departments_products;
use App\Models\Invoice;
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
        Schema::create('trans_references', function (Blueprint $table) {
            $table->id();
            $table->string('MSISDN');
            $table->string('TransID');
            $table->integer('TransAmount');
            $table->string('BillRefNumber');
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
        Schema::dropIfExists('trans_references');
    }
};
