<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Exports\PermissionExport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function UpdatePermission(Request $request) {
        $permission = Permission::findOrFail($request->id);
        $permission->name = $request->name;
        $permission->group_name = $request->group_name;
        $permission->save();

        $notification = array(
            "message" => "Permission updated successfully", 
            "alert-type" => "success"
        );

        return redirect()->route('all.permissions')->with($notification);
    }
    
    public function DeletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        
        if ($permission) {
            $permission->delete();
            
            $notification = array(
                "message" => "Permission deleted successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.permissions')->with($notification);
        }
        else {
            $notification = array(
                "message" => "Permission not found", 
                "alert-type" => "error"
            );
            return redirect()->back()->with($notification);
        }
    }

    public function EditPermission($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.backend.pages.permission.edit_permission', compact('permission'));
    }

    public function ImportPermission() {
        return view('admin.backend.pages.permission.import_permission');
    }

    public function ExportExcelPermission() {
        return Excel::download(new PermissionExport, 'permissions.xlsx');
    }
}
