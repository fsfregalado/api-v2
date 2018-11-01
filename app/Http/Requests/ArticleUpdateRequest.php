<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ArticleUpdateRequest extends FormRequest
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
            'image' => 'required|image',
            'user_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo title é obrigatório',
            'title.unique' => 'O campo title deve ser único',
            'description.required' => 'O campo description é obrigatório',
            'image.required' => 'O campo image é obrigatório',
            'image.image' => 'O campo image deve ser do tipo imagem',
            'user_id.required' => 'O campo user_id é obrigatório'
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
