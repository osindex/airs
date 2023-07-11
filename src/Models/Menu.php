<?php

namespace Osi\Airs\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title', 'options', 'is_aside', 'is_header', 'parent_id', 'name', 'icon', 'uri', 'is_link', 'guard_name', 'permission_name', 'sequence', 'is_display', 'description', 'cus_id', 'cus_type', 'redirect', 'component'];
    protected $casts = [
        'options' => 'json'
    ];
}
