<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StoreReportsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' =>'required',
            'to'=>'required|exists:users,id',
            'subject' =>'required',
            'file'=>'required|mimes:pdf|max:2048'
        ];
    }

    protected function passedValidation()
    {
        $data = $this->validated();
        $data['target_id']=$this->to;
        $this->replace($data);
    }
}
