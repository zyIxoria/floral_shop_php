<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('cod', 'vnpay', 'bank_transfer') NOT NULL DEFAULT 'cod'");
        DB::statement("ALTER TABLE payments MODIFY method ENUM('cod', 'vnpay', 'bank_transfer') NOT NULL DEFAULT 'cod'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('cod', 'vnpay') NOT NULL DEFAULT 'cod'");
        DB::statement("ALTER TABLE payments MODIFY method ENUM('cod', 'vnpay') NOT NULL DEFAULT 'cod'");
    }
};
