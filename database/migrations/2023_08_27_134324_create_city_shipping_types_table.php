<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('city_shipping_types', function (Blueprint $table) {
            $table->foreignId('city_id')->constrained();
            $table->foreignId('shipping_type_id')->constrained();
            $table->decimal('shipping_price', 12)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_shipping_types');
    }
};
