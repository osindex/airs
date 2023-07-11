<?php

namespace Osi\Airs;


use Illuminate\Database\Eloquent\Model;

class AdminUserFactory
{
    /**
     * @return Model
     */
    public static function adminUser()
    {
        return app(config('airs.guards.admin.model'));
    }
}