<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BarangRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'barang_code' => [
        'required',
        'min:2',
        'max:255',
        'string',
        Rule::unique('mst_barang', 'barang_code')->ignore($this->id),
      ],
      'barang_name' => [
        'required',
        'min:2',
        'max:255',
        'string',
        Rule::unique('mst_barang', 'barang_name')->ignore($this->id),
      ],
      'satuan' => 'required|string|max:255|min:2',
      'qty' => 'nullable|numeric',
      'min_qty' => 'nullable|numeric',
      'barang_photo' => 'nullable|image|mimes:jpeg,png|max:1024', // Max file size: 1MB
      'active' => 'required',
    ];
  }
}
