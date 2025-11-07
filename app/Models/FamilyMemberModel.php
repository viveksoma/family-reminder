<?php

namespace App\Models;

use CodeIgniter\Model;

class FamilyMemberModel extends Model
{
    protected $table = 'family_members';
    protected $primaryKey = 'id';
    protected $allowedFields = ['family_id', 'user_id'];
}
