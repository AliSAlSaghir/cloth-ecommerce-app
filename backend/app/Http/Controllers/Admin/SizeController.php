<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    return Size::latest()->get();;
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $request->validate([
      'name' => 'required|max:255|unique:sizes',
    ]);
    $size = Size::create($request->all());
    return $size;
  }

  /**
   * Display the specified resource.
   */
  public function show(Size $size) {
    return $size;
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Size $size) {
    $request->validate([
      'name' => 'required|max:255|unique:sizes,name,' . $size->id,
    ]);
    $size->update($request->all());
    return $size;
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Size $size) {
    $size->delete();
    return response()->noContent();
  }
}
