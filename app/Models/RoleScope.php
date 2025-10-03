<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleScope extends Model
{
    protected $fillable = ['role_id', 'module', 'scope'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
