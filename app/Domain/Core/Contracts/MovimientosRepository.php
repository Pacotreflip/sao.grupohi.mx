<?php
/**
 * Created by PhpStorm.
 * User: mirah
 * Date: 03/01/2018
 * Time: 10:48 AM
 */

namespace Ghi\Domain\Core\Contracts;


interface MovimientosRepository
{
    public function all();

    public function find($id);

    public function with($relations);

    public function create($data);

    public function update($data, $id);

    public function delete($id);
}