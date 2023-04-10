<?php

namespace Modules\Permission\Http\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Permission\Models\Permission;

/** @mixin Permission */
class PerimssionResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'permissions_count' => $this->permissions_count,
            'roles_count' => $this->roles_count,
        ];
    }
}
