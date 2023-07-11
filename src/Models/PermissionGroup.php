<?php

namespace Osi\Airs\Models;


use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $guarded = ['id'];

    public function permission()
    {
        return $this->hasMany('Osi\Airs\Models\Permission', 'pg_id');
    }
}