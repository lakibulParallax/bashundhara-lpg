<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Models\Meter;
use App\Models\System\Permission as ModelPermission;
use App\Models\System\Role as ModelRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Exception;

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

    public function store(Request $request)
    {
        try{
            $create       = new Role;
            $create->name = $request->name;
            if($request->status)
            {
                $create->status   = $request->status;
            }
            else{
                $create->status   = 0;
            }
            $create->role_type  = 1;
            $create->guard_name = 'admin';
            $create->save();
            if($request->permissions)
            {
                $permissions = $request->permissions;
            }
            else{
                $permissions = [];
            }
            $create->givePermissionTo(Permission::whereIn('id', $permissions)->get());

            $notification = array(
                "message"    => 'Role Created Successfully!',
                "alert-type" => 'success'
            );
            return redirect()->route('admin.role.list')->with($notification);
        }
        catch(Exception $e)
        {
            Log::info($e);
            $notification = array(
                "message"    => 'Something went wrong!',
                "alert-type" => 'error'
            );
            return redirect()->route('admin.role.add')->with($notification);
        }
    }

    public function edit($id)
    {
        try{
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

            $role = ModelRole::with(['permissions'])
                ->where('id', $id)
                ->first();
            if(empty($role))
            {
                $notification = array(
                    "message"    => 'Role Not Found!',
                    "alert-type" => 'error'
                );
                return redirect()->route('admin.role.list')->with($notification);
            }
            else{
                return view('admin.role.edit', compact('role', 'permissions'));
            }
        }
        catch(Exception $e)
        {
            Log::info($e);
            $notification = array(
                "message"    => 'Something went wrong!',
                "alert-type" => 'error'
            );
            return redirect()->route('admin.role.list')->with($notification);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $update       = Role::find($id);
            $update->name = $request->name;
            if(isset($request->status))
            {
                $update->status = $request->status;
            }
            else{
                $update->status = 0;
            }
            // $update->role_type  = $request->role_type;
//            $update->updated_by = Auth::Id();
            $update->save();
            if($request->permissions)
            {
                $permissions = $request->permissions;
            }
            else{
                $permissions = [];
            }
            $update->syncPermissions(Permission::whereIn('id', $permissions)->get());

            $notification = array(
                "message"    => 'Role Updated Successfully!',
                "alert-type" => 'success'
            );
            return redirect()->route('admin.role.list')->with($notification);
        }
        catch(Exception $e)
        {
            Log::info($e);
            $notification = array(
                "message"    => 'Something went wrong!',
                "alert-type" => 'error'
            );
            return redirect()->route('admin.role.list')->with($notification);
        }
    }
}
