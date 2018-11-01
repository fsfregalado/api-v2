<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserTypeStoreRequest extends FormRequest
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
            //
            'title' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo title é obrigatório'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        //throw new ErrorException($validator->errors()->first());
        throw new HttpResponseException(response()->json(
            [
                'status' => 422,
                'data' => $validator->errors(),
                'msg' => "Erro de validação."
            ], 422
        ));
    }
}
