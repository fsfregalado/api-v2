<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ArticleStoreRequest extends FormRequest
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
            'title' => 'required|unique:articles',
            'description' => 'required',
            'image' => 'image'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo title é obrigatório',
            'title.unique' => 'O campo title deve ser único',
            'description.required' => 'O campo description é obrigatório',
            'image.required' => 'O campo image é obrigatório',
            'image.image' => 'O campo image deve ser do tipo imagem'
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
