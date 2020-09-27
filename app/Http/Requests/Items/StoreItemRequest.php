<?php

namespace App\Http\Requests\Items;

use App\Libraries\Utilities;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreItemRequest extends FormRequest
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
            'name' => 'required|string|unique:items'
        ];
    }

    public function failedValidation(Validator $validator)
    {
//        parent::failedValidation();
        throw new HttpResponseException($this->library()->responder($validator->errors()->first(), 422, 'Validation Error'));
    }

    private function library()
    {
        return new Utilities();
    }
}
