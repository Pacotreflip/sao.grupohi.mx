<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 16/05/2018
 * Time: 09:42 AM
 */

namespace Ghi\Domain\Core\Layouts\Presupuestos;


use Ghi\Domain\Core\Layouts\ValidacionLayout;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use MCrypt\MCrypt;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Ghi\Domain\Core\Models\Transacciones\ContratoProyectado;

class AsignacionCargaPreciosLayout extends ValidacionLayout
{
    /**
     * @var ContratoProyectado
     */
    protected $contrato_proyectado;
    /**
     * @var array
     */
    protected $resultData = [];

    /**
     * @var array
     */
    protected $headerFijos = [

    ];

    /**
     * @var array
     */
    protected $headerDinamicos = [

    ];

    /**
     * AsignacionSubcontratistasLayout constructor.
     * @param ContratoProyectado $contrato_proyectado
     */
    public function __construct(ContratoProyectado $contrato_proyectado)
    {
        $this->mCrypt = new MCrypt();
        $this->mCrypt->setKey($this->Key);
        $this->mCrypt->setIv($this->Iv);
        $this->lengthHeaderFijos = count($this->headerFijos);
        $this->lengthHeaderDinamicos = count($this->headerDinamicos);
        $this->contrato_proyectado = $contrato_proyectado;
    }

    /**
     * @param ContratoProyectado $contrato_proyectado
     * @return mixed
     */
    public function setData(ContratoProyectado $contrato_proyectado)
    {

    }

    /**
     * @return mixed
     */
    public function getFile()
    {

    }

    /**
     * @param Request $request
     * @return bool
     */
    public function qetDataFile(Request $request)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $results = false;
        Excel::load($request->file('file')->getRealPath(), function ($reader) use (&$results) {
            //try {
                $results = $reader->all();
                $sheet = $reader->sheet($results->getTitle(), function (LaravelExcelWorksheet $sheet) {
                    $sheet->getProtection()->setSheet(false);
                });
                $folio = explode(' ', $results->getTitle());
                //->Validar que el Layout corresponda a la transacción
                /*if ('# ' . str_pad($this->contrato_proyectado->numero_folio, 5, '0', STR_PAD_LEFT) != $results->getTitle()) {
                    throw new \Exception("No corresponde el layout al Contrato");
                }*/
                $headers = $results->getHeading();
                $col = $sheet->toArray();
                dd($col);
                if ($this->validarHeader($headers, $layout)) {

                }
            /*} catch (\Exception $e) {
                if (count($this->resultData) > 0) {
                    throw new StoreResourceFailedException($e->getMessage(), $this->resultData);
                } else {
                    throw new StoreResourceFailedException($e->getMessage());
                }
            }*/
        });
        return $results;
    }
}