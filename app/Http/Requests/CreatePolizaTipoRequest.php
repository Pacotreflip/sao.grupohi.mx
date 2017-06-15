<?php

namespace Ghi\Http\Requests;

use Ghi\Http\Requests\Request;

class CreatePolizaTipoRequest extends Request
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
            'id_transaccion_interfaz' => 'required|exists:cadeco.Contabilidad.int_transacciones_interfaz,id_transaccion_interfaz',
            'inicio_vigencia'=>'required|date_format:"Y-m-d"',
                    ];
    }
}
