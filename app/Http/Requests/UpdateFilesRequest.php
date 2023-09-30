<?php

namespace App\Http\Requests;

use App\Models\Files;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateFilesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status'=>['required',Rule::in(['rejected','accepted','revision'])],
            'comment'=>[Rule::requiredIf(function(){
                return $this->status!=='accepted';
            }),'string','nullable'],
            'file_path'=>[Rule::requiredIf(function(){
                return $this->status=='accepted';
            }),'mimeTypes:application/pdf','max:2048'],
        ];
    }

    protected function passedValidation()
    {
        $data = $this->validated();
        $this->replace(Arr::only($data,['status','comment','file_path']));
    }
}
