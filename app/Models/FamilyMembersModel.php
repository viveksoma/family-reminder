<?php

namespace App\Models;

use CodeIgniter\Model;

class FamilyMembersModel extends Model
{
    protected $table = 'family_members';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'family_id',
        'user_id',
        'role'
    ];

    // Optional helper method to get all families of a user
    public function getFamiliesByUser($userId)
    {
        return $this->select('families.id, families.name, family_members.role')
                    ->join('families', 'families.id = family_members.family_id')
                    ->where('family_members.user_id', $userId)
                    ->findAll();
    }
}
