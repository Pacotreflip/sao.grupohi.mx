<?php
/**
 * Created by PhpStorm.
 * User: mirah
 * Date: 18/06/2018
 * Time: 06:02 PM
 */

namespace Ghi\Api\Controllers\v1\Finanzas;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class CargaExpedienteController extends Controller
{
    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $rules = array(
            'file' => 'required|mimetypes:application/pdf',
        );

        $validator =  app('validator')->make($request->all(), $rules);
        if (count($validator->errors()->all())) {
            throw new StoreResourceFailedException('No es posible cargar el Layout', $validator->errors());
        }

        $path = Storage::putFile('', $request->file(''));
    }
}