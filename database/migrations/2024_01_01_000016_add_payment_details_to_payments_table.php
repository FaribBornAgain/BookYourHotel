<?php
// File: database/migrations/2024_01_01_000016_add_payment_details_to_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentDetailsToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('bkash_trx_id')->nullable()->after('transaction_id');
            $table->string('payment_phone')->nullable()->after('bkash_trx_id');
            $table->text('payment_details')->nullable()->after('payment_phone');
            $table->timestamp('confirmed_at')->nullable()->after('payment_date');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['bkash_trx_id', 'payment_phone', 'payment_details', 'confirmed_at']);
        });
    }
}