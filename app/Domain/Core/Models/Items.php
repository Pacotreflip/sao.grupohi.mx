<?php

namespace Ghi\Domain\Core\Models;


class Items extends BaseModel
{
    protected $connection = 'cadeco';
    protected $table = 'dbo.items';
    protected $primaryKey = 'id_itemn';

}
