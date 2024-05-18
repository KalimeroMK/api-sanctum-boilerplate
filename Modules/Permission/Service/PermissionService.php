<?php

namespace Modules\Permission\Service;

use Modules\Core\Service\CoreService;
use Modules\Permission\Repository\PermissionRepository;

class PermissionService extends CoreService
{

    public PermissionRepository $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        parent::__construct($this->permissionRepository = $permissionRepository);
    }

}