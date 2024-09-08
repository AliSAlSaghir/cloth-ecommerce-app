<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    return Color::latest()->get();;
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $request->validate([
      'name' => 'required|max:255|unique:colors',
    ]);
    $color = Color::create($request->all());
    return $color;
  }

  /**
   * Display the specified resource.
   */
  public function show(Color $color) {
    return $color;
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Color $color) {
    $request->validate([
      'name' => 'required|max:255|unique:colors,name,' . $color->id,
    ]);
    $color->update($request->all());
    return $color;
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Color $color) {
    $color->delete();
    return response()->noContent();
  }
}
