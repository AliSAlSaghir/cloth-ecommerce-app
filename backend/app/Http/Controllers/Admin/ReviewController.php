<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    return Review::latest()->get();
  }


  public function toggleApprovedStatus(Request $request, Review $review) {
    $request->validate([
      'approved' => 'required|boolean'
    ]);

    $review->update([
      'approved' => $request->approved
    ]);

    return response()->json([
      'review' => $review,
      'message' => 'Review approved',
    ]);
  }

  public function destroy(Review $review) {
    $review->delete();
    return response()->noContent();
  }
}
