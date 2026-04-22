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
        Schema::table('orders', function (Blueprint $table): void {
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            $table->string('momo_order_id')->nullable()->unique()->after('paid_at');
            $table->string('momo_request_id')->nullable()->unique()->after('momo_order_id');
            $table->string('momo_trans_id')->nullable()->after('momo_request_id');
            $table->text('momo_pay_url')->nullable()->after('momo_trans_id');
            $table->text('momo_qr_code')->nullable()->after('momo_pay_url');
            $table->json('momo_response')->nullable()->after('momo_qr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropUnique(['momo_order_id']);
            $table->dropUnique(['momo_request_id']);
            $table->dropColumn([
                'payment_status',
                'paid_at',
                'momo_order_id',
                'momo_request_id',
                'momo_trans_id',
                'momo_pay_url',
                'momo_qr_code',
                'momo_response',
            ]);
        });
    }
};
