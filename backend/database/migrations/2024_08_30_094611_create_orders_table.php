<?php

use App\Models\Coupon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->integer('qty');
      $table->decimal('total', 8, 2);
      $table->datetime('delivered_at')->nullable();
      $table->foreignIdFor(User::class)->cascadeOnDelete();
      $table->foreignIdFor(Coupon::class)->nullable()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('orders');
  }
};
