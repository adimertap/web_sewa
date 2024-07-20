<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
      'name' => [
        'required',
        'min:5',
        'string',
        Rule::unique('users', 'name')->ignore($this->id),
      ],
      'email' => [
        'required',
        'email',
        'string',
        'min:5',
        Rule::unique('users', 'email')->ignore($this->id),
      ],
      'role' => [
        'required'
      ],
      'password_user' => [
        'required',
        'min:5',
      ],
      'seksi_id' => [
        'required',
        Rule::exists('mst_seksi', 'seksi_id'),
      ]
    ];
  }
}
