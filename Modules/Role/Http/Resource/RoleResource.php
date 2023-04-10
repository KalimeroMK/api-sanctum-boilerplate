<?php

namespace Modules\Role\Http\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Permission\Http\Resource\PerimssionResource;

/** @mixin \Modules\Role\Models\Role */
class RoleResource extends JsonResource
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
            'permissions' => PerimssionResource::collection($this->whenLoaded('permissions')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
