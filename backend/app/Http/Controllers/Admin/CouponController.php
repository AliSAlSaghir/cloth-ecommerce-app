<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    return Coupon::latest()->get();;
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $request->validate([
      'name' => 'required|max:255|unique:coupons',
      'discount' => 'required',
      'valid_until' => 'required',
    ], [
      'valid_until.required' => 'The coupon validity is required.',
    ]);
    $coupon = Coupon::create($request->all());
    return $coupon;
  }

  /**
   * Display the specified resource.
   */
  public function show(Coupon $coupon) {
    return $coupon;
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Coupon $coupon) {
    $request->validate([
      'name' => 'required|max:255|unique:coupons,name,' . $coupon->id,
      'discount' => 'required',
      'valid_until' => 'required',
    ], [
      'valid_until.required' => 'The coupon validity is required.',
    ]);
    $coupon->update($request->all());
    return $coupon;
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Coupon $coupon) {
    $coupon->delete();
    return response()->noContent();
  }
}
