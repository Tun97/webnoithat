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
        Schema::table('users', function (Blueprint $table): void {
            $table->text('address_line')->nullable()->after('address');
            $table->unsignedInteger('province_id')->nullable()->after('address_line');
            $table->string('province_name')->nullable()->after('province_id');
            $table->unsignedInteger('district_id')->nullable()->after('province_name');
            $table->string('district_name')->nullable()->after('district_id');
            $table->string('ward_code', 32)->nullable()->after('district_name');
            $table->string('ward_name')->nullable()->after('ward_code');
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->text('address_line')->nullable()->after('address');
            $table->unsignedInteger('province_id')->nullable()->after('address_line');
            $table->string('province_name')->nullable()->after('province_id');
            $table->unsignedInteger('district_id')->nullable()->after('province_name');
            $table->string('district_name')->nullable()->after('district_id');
            $table->string('ward_code', 32)->nullable()->after('district_name');
            $table->string('ward_name')->nullable()->after('ward_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropColumn([
                'address_line',
                'province_id',
                'province_name',
                'district_id',
                'district_name',
                'ward_code',
                'ward_name',
            ]);
        });

        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'address_line',
                'province_id',
                'province_name',
                'district_id',
                'district_name',
                'ward_code',
                'ward_name',
            ]);
        });
    }
};
