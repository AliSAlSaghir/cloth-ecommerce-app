<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {

  public function index(Product $product) {
    $reviews = $product->reviews()->where('approved', true)->latest()->get();
    return response()->json($reviews);
  }

  public function show(Product $product, Review $review) {
    if ($review->product_id !== $product->id) {
      return response()->json([
        'error' => 'This review does not belong to the specified product'
      ], 400);
    }

    if (!$review->approved) {
      return response()->json([
        'error' => 'This review is not approved'
      ], 403);
    }

    return response()->json($review);
  }


  public function store(Request $request, Product $product) {
    $exists = $this->checkIfUserAlreadyReviewedTheProduct($product, $request->user()->id);
    if ($exists) {
      return response()->json([
        'error' => 'You have already reviewed this product'
      ], 400);
    }

    $request->validate([
      'title' => 'required|string|max:255',
      'body' => 'required|string',
      'rating' => 'required|integer|min:1|max:5'
    ]);

    $review = $product->reviews()->create([
      'user_id' => $request->user()->id,
      'title' => $request->title,
      'body' => $request->body,
      'rating' => $request->rating,
    ]);
    return response()->json($review);
  }

  protected function checkIfUserAlreadyReviewedTheProduct($product_id, $user_id) {
    $review = Review::where([
      'product_id' => $product_id,
      'user_id' => $user_id
    ])->first();
    return $review;
  }

  public function update(Request $request, Product $product, Review $review) {
    $request->validate([
      'title' => 'string|max:255',
      'body' => 'string',
      'rating' => 'integer|min:1|max:5'
    ]);

    if ($review->product_id !== $product->id) {
      return response()->json([
        'error' => 'This review does not belong to the specified product'
      ], 400);
    }

    if ($review->user_id !== $request->user()->id) {
      return response()->json([
        'error' => 'You are not authorized to update this review'
      ], 403);
    }

    $review->update([
      'title' => $request->title,
      'body' => $request->body,
      'rating' => $request->rating,
      'approved' => 0
    ]);

    return response()->json($review);
  }


  public function destroy(Request $request, Product $product, Review $review) {
    if ($review->product_id !== $product->id) {
      return response()->json([
        'error' => 'This review does not belong to the specified product'
      ], 400);
    }

    if ($review->user_id !== $request->user()->id) {
      return response()->json([
        'error' => 'You are not authorized to delete this review'
      ], 403);
    }

    $review->delete();

    return response()->noContent();
  }
}
