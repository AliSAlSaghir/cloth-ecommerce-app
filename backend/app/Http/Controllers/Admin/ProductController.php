<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    return Product::with(['colors', 'sizes'])->latest()->get();;
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(AddProductRequest $request) {
    $data = $request->validated();
    $data['thumbnail'] = $this->saveImage($request->file('thumbnail'));
    //check if the admin upload the first image
    if ($request->has('first_image')) {
      $data['first_image'] = $this->saveImage($request->file('first_image'));
    }
    //check if the admin upload the second image
    if ($request->has('second_image')) {
      $data['second_image'] = $this->saveImage($request->file('second_image'));
    }
    //check if the admin upload the third image
    if ($request->has('third_image')) {
      $data['third_image'] = $this->saveImage($request->file('third_image'));
    }
    //add the slug
    $data['slug'] = Str::slug($request->name);
    $product = Product::create($data);
    $product->colors()->sync($request->color_id);
    $product->sizes()->sync($request->size_id);

    return $product;
  }

  /**
   * Display the specified resource.
   */
  public function show(Product $product) {
    return $product;
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateProductRequest $request, Product $product) {
    $data = $request->all();

    if ($request->has('thumbnail')) {
      $this->removeProductImageFromStorage($request->file('thumbnail'));
      $data['thumbnail'] = $this->saveImage($request->file('thumbnail'));
    }
    //check if the admin upload the first image
    if ($request->has('first_image')) {
      $this->removeProductImageFromStorage($request->file('first_image'));
      $data['first_image'] = $this->saveImage($request->file('first_image'));
    }
    //check if the admin upload the second image
    if ($request->has('second_image')) {
      $this->removeProductImageFromStorage($request->file('second_image'));
      $data['second_image'] = $this->saveImage($request->file('second_image'));
    }
    //check if the admin upload the third image
    if ($request->has('third_image')) {
      $this->removeProductImageFromStorage($request->file('third_image'));
      $data['third_image'] = $this->saveImage($request->file('third_image'));
    }
    //add the slug
    $data['slug'] = Str::slug($request->name);
    $product->update($data);
    $product->colors()->sync($request->color_id);
    $product->sizes()->sync($request->size_id);

    return $product;
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product) {
    $this->removeProductImageFromStorage($product->thumbnail);
    $this->removeProductImageFromStorage($product->first_image);
    $this->removeProductImageFromStorage($product->second_image);
    $this->removeProductImageFromStorage($product->third_image);

    $product->delete();
    return response()->noContent();
  }

  protected function saveImage($file) {
    $image_name = time() . '_' . $file->getClientOriginalName();
    $file->storeAs('images/products/', $image_name, 'public');
    return 'storage/images/products/' . $image_name;
  }

  protected function removeProductImageFromStorage($file) {
    $path = public_path('storage/images/products/', $file);
    if (File::exists($path)) File::delete($path);
  }
}
