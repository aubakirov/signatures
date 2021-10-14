<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignatureStoreRequest extends FormRequest
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
            'name' => 'required|max:11|unique:signatures,name,' . $this->signature->id,
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Имя уже должно быть уникальное.'
        ];
    }
}
