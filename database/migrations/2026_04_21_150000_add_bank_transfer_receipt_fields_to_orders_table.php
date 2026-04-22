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
            $table->string('bank_transfer_receipt_path')->nullable()->after('momo_response');
            $table->string('bank_transfer_receipt_original_name')->nullable()->after('bank_transfer_receipt_path');
            $table->timestamp('bank_transfer_receipt_uploaded_at')->nullable()->after('bank_transfer_receipt_original_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropColumn([
                'bank_transfer_receipt_path',
                'bank_transfer_receipt_original_name',
                'bank_transfer_receipt_uploaded_at',
            ]);
        });
    }
};
