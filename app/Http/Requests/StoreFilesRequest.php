<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class StoreFilesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status'=>Rule::in(['revision','accepted']),
            'description'=>'string|nullable',
            'file_path'=>'required|mimeTypes:application/pdf|max:2048'
        ];
    }

    protected function passedValidation()
    {
        $data = $this->validated();

        $data = Arr::only($data,['description','file_path','status']);
        $this->replace($data);
    }
}
