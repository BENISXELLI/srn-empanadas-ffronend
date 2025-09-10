<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpanadaModel extends Model
{
    protected $table      = 'empanadas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'name',
        'type',
        'filling',
        'price',
        'is_sold_out'
    ];

    // Si usas created_at y updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}