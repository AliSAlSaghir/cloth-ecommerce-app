<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('reviews', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->longText('body');
      $table->integer('rating');
      $table->boolean('approved')->default(0);
      $table->foreignIdFor(User::class)->cascadeOnDelete();
      $table->foreignIdFor(Product::class)->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('reviews');
  }
};
