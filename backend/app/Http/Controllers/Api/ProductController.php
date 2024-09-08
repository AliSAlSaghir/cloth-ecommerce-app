<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;

class ProductController extends Controller {

  public function index() {
    return ProductResource::collection(Product::with(['colors', 'sizes', 'reviews'])->latest()->get())
      ->additional([
        'colors' => Color::has('products')->get(),
        'sizes' => Size::has('products')->get(),
      ]);
  }

  public function show(Product $product) {
    return ProductResource::make($product->load(['colors', 'sizes', 'reviews']));
  }

  public function filterProductsByColor(Color $color) {
    return ProductResource::collection($color->products()->with(['colors', 'sizes', 'reviews'])->latest()->get())
      ->additional([
        'colors' => Color::has('products')->get(),
        'sizes' => Size::has('products')->get(),
      ]);
  }

  public function filterProductsBySize(Size $size) {
    return ProductResource::collection($size->products()->with(['colors', 'sizes', 'reviews'])->latest()->get())
      ->additional([
        'colors' => Color::has('products')->get(),
        'sizes' => Size::has('products')->get(),
      ]);
  }

  public function filterProductsByTerm($searchTerm) {
    return ProductResource::collection(Product::where('name', 'LIKE', "%{$searchTerm}%")->with(['colors', 'sizes', 'reviews'])->latest()->get())
      ->additional([
        'colors' => Color::has('products')->get(),
        'sizes' => Size::has('products')->get(),
      ]);
  }
}
