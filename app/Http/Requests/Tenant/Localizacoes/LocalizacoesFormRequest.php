<?php

namespace App\Http\Requests\Tenant\Localizacoes;

use App\Models\Tenant\TeamMember;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LocalizacoesFormRequest extends FormRequest
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
     * Messages to display to the user
     *
     * @return void
     */
    public function messages()
    {
        return [
          'cod_barras.required' => __("O código de barras é de preenchimento obrigatório."),
          'descricao.min' => __("A descrição é de preenchimento obrigatório."),
          'abreviatura.required' => __("A aberviatura é de preenchimento obrigatório."),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
              'cod_barras' => ['required'],
              'descricao' => ['required'],
              'abreviatura' => ['required'],
            ];

    }
}
