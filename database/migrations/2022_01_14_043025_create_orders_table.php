<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("address_id")->references("id")->on("user_addresses")->onDelete("cascade")->onUpdate("cascade");
            $table->integer("amount");
            $table->boolean("payment_mode")->default(0);// definign whether payment is online(1) or COD (0)
            $table->boolean("payment_status")->default(0); //defining payment status with paid (1) and unpadi (0)
            $table->string("payment_id")->default(0); // storing payent getway optional id
            $table->string("transaction_id")->default(0);//transaction id for the payment whether it is online or offline
            $table->boolean("coupon_used")->default(0);
            $table->boolean("status")->default(0); // processing (0) , dispatched (1) , delivered(2)
          
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
        Schema::dropIfExists('orders');
    }
}
