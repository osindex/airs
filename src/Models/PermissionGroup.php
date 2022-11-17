<?php

namespace Zkuyuo\Airs\Models;


use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $guarded = ['id'];

    public function permission()
    {
        return $this->hasMany('Zkuyuo\Airs\Models\Permission', 'pg_id');
    }
}