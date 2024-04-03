<?php

use App\Models\Departments_products;
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
        Schema::table('departments_products', function (Blueprint $table) {
            $table->string('vatable')->after('amount');
<<<<<<< HEAD
=======
            
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments_products', function (Blueprint $table) {
            $table->dropColumn('vatable');
<<<<<<< HEAD

=======
            
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
        });
    }
};
