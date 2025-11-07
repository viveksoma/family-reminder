<?php

namespace App\Models;

use CodeIgniter\Model;

class WarrantyModel extends Model
{
    protected $table = 'warranties';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'family_id',
        'item_name',
        'purchase_date',
        'expiry_date',
        'warranty_document',
        'notes',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    public function getUserWarranties($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }
}
