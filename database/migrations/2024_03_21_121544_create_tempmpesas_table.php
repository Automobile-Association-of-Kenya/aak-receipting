<?php

use App\Models\Invoice;
use App\Models\members;
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
        Schema::create('tempmpesas', function (Blueprint $table) {
            $table->id();
                $table->foreignIdFor(members::class);
                $table->foreignIdFor(Invoice::class);
            $table->string('phone');
            $table->string('amount');
            $table->string('description')->nullable();
            $table->string('checkoutid');
            $table->string('mpesareference')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

//             {
//     "phone":"254715614272",
//     "amount":"1",
//     "description":"payment for test app",
//     "callBackUrl":"https://xyz.com/api/callBack"
// }
//             {
//     "phone": "254743970626",
//     "amount": "1",
//     "description": "payment for test app",
//     "callBackUrl": "https://8592-41-90-177-38.ngrok-free.app/api/callBack",
//     "checkoutID": "ws_CO_20032024204754184743970626",
//     "requestTimeStamp": "20240320204755",
//     "source": null,
//     "owner": null,
//     "agent": null,
//     "destination": null,
//     "mpesaReference": "SCK4L9AQAS",
//     "id": 6755,
//     "status": "SUCCESSFUL",
//     "date_created": "2024-03-20T17:47:56.000Z",
//     "date_updated": "2024-03-20T17:47:56.000Z"
// }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tempmpesas');
    }
};
