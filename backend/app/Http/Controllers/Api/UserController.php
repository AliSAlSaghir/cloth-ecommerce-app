<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller {
  public function updateUserProfile(Request $request) {
    $request->validate([
      'profile_image' => 'image|mimes:png,jpg,jpeg|max:2048'
    ]);

    if ($request->has('profile_image')) {
      //check if the old image exists and remove it
      if (File::exists(public_path($request->user()->profile_image))) {
        File::delete(public_path($request->user()->profile_image));
      }
      //get and store the new image file
      $file = $request->file('profile_image');
      $profile_image_name = time() . '_' . $file->getClientOriginalName();
      $file->storeAs('images/users/', $profile_image_name, 'public');
      //update the user image
      $request->user()->update([
        'profile_image' =>  'storage/images/users/' . $profile_image_name
      ]);
    } else {
      //update the user info
      $request->user()->update([
        'country' => $request->country,
        'city' => $request->city,
        'address' => $request->address,
        'zip_code' => $request->zip_code,
        'phone_number' => $request->phone_number,
      ]);
    }
    //return the response
    return response()->json(UserResource::make($request->user()));
  }
}
