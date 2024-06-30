<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Meter;
use App\Models\System\Permission as ModelPermission;
use App\Models\System\Role as ModelRole;

class RoleManagementController extends Controller
{
    public function add()
    {
        $all_permissions = ModelPermission::orderBy('id', 'asc')
            ->get()
            ->groupBy('group_name')
            ->toArray();

        $permissions = [];
        foreach ($all_permissions as $key => $permission) {
            $single_item = array(
                "group_name"   => $key,
                "permissions"  => $permission
            );
            array_push($permissions, $single_item);
        }
        $data['permissions'] = $permissions;

        return view('admin.role.create', $data);
    }

    public function index()
    {
        $data['roles'] = ModelRole::with(['permissions.permission'])
            ->orderby('id', 'desc')
            ->get();

        return view('admin.role.index', $data);
    }
}
