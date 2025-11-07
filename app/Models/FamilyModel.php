<?php

namespace App\Models;

use CodeIgniter\Model;

class FamilyModel extends Model
{
    protected $table = 'families';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'created_by_user_id'
    ];

    protected $useTimestamps = true; // automatically manages created_at and updated_at
}
