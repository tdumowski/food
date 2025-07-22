<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function AllPermssions() {
        $permissions = Permission::all();
        return view('admin.backend.pages.permission.all_permissions', compact('permissions'));
    }

    public function AddPermssion() {
        return view('admin.backend.pages.permission.add_permission');
    }

    public function StorePermssion(Request $request) {
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->group_name = $request->group_name;
        $permission->guard_name = 'admin';
        $permission->save();

        $notification = array(
            "message" => "Permission created successfully", 
            "alert-type" => "success"
        );

        return redirect()->route('all.permissions')->with($notification);
    }
}
