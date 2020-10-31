<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'max:255',
            'first_name' => 'required|max:255',
            'middle_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone_number' => 'max:20',
            'city_id' => 'required',
            'is_eaten' => 'required',
            'id' => 'required',
            'login' => [
                'required',
                'max:255',
                Rule::unique('users')->ignore($this->capture()->post('id'), 'id')
            ],
            'email' => [
                'required',
                'max:255',
                'email',
                Rule::unique('users')->ignore($this->capture()->post('id'), 'id')
            ],
        ];
    }
}
