<?php namespace Ghi\Domain\Core\Contracts;

interface TransaccionInterfazRepository
{
    public function getById($id);
    public function getAll();
    public function lists();
}