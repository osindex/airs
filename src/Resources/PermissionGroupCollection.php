<?php

namespace Osi\Airs\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionGroupCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}