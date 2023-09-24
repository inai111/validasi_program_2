<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'=>'required|email|unique:users',
            'name'=>'required|min:3',
            'password'=>'required|min:6|max:12',
        ];
    }

    protected function passedValidation()
    {
        $this->replace($this->validated());
    }
}
