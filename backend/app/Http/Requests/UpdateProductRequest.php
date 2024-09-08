<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest {
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array {
    return [
      //
      'name' => 'required|max:255|unique:products,name,' . $this->product->id,
      'qty' => 'required|numeric',
      'price' => 'required|numeric',
      'color_id' => 'required|array',
      'color_id.*' => 'exists:colors,id',
      'size_id' => 'required|array',
      'size_id.*' => 'exists:sizes,id',
      'desc' => 'required|max:2000',
      'thumbnail' => 'image|mimes:png,jpg,jpeg|max:2048',
      'first_image' => 'image|mimes:png,jpg,jpeg|max:2048',
      'second_image' => 'image|mimes:png,jpg,jpeg|max:2048',
      'third_image' => 'image|mimes:png,jpg,jpeg|max:2048',
    ];
  }

  public function messages() {
    return [
      'color_id.required' => 'The color field is required',
      'color_id.exists' => 'The selected color is invalid',
      'size_id.required' => 'The size field is required',
      'size_id.exists' => 'The selected size is invalid',
      'desc.required' => 'The description field is required',
      'desc.max' => 'The description must not be greater than 2000 characters',
      'qty.required' => 'The quantity field is required',
      'thumbnail.max' => 'The thumbnail must not be greater than 2MB',
      'thumbnail.image' => 'The thumbnail must be an image',
      'first_image.max' => 'The first image must not be greater than 2MB',
      'first_image.image' => 'The first image must be an image',
      'second_image.max' => 'The second image must not be greater than 2MB',
      'second_image.image' => 'The second image must be an image',
      'third_image.max' => 'The third image must not be greater than 2MB',
      'third_image.image' => 'The third image must be an image',
    ];
  }
}
