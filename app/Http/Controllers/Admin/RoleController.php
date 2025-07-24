<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function AddAdmin() {
        $roles = Role::all();
        return view('admin.backend.pages.admin.add_admin', compact('roles'));
    }

    public function AddPermssion() {
        return view('admin.backend.pages.permission.add_permission');
    }

    public function AddRole() {
        return view('admin.backend.pages.role.add_role');
    }

    public function AddRolePermission() {
        $roles = Role::all();
        $permissions = Permission::all();
        $permissionGroups = Admin::getPermissionGroups();

        return view('admin.backend.pages.rolesetup.add_role_permission', compact('roles', 'permissions', 'permissionGroups'));
    }

    public function AllAdmins() {
        $admins = Admin::all();
        return view('admin.backend.pages.admin.all_admins', compact('admins'));
    }

    public function AllPermssions() {
        $permissions = Permission::all();
        return view('admin.backend.pages.permission.all_permissions', compact('permissions'));
    }

    public function AllRoles() {
        $roles = Role::all();
        return view('admin.backend.pages.role.all_roles', compact('roles'));
    }
    
    public function AllRolePermission() {
        $roles = Role::all();
        $permissions = Permission::all();
        $permissionGroups = Admin::getPermissionGroups();

        return view('admin.backend.pages.rolesetup.all_role_permission', compact('roles', 'permissions', 'permissionGroups'));
    }

    public function DeleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        
        if ($admin) {
            $admin->delete();
            
            $notification = array(
                "message" => "Admin deleted successfully", 
                "alert-type" => "success"
            );
            return redirect()->back()->with($notification);
        }
        else {
            $notification = array(
                "message" => "Admin not found", 
                "alert-type" => "error"
            );
            return redirect()->back()->with($notification);
        }
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
    
    public function DeleteRole($id)
    {
        $role = Role::findOrFail($id);
        
        if ($role) {
            $role->delete();
            
            $notification = array(
                "message" => "Role deleted successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.roles')->with($notification);
        }
        else {
            $notification = array(
                "message" => "Role not found", 
                "alert-type" => "error"
            );
            return redirect()->back()->with($notification);
        }
    }

    public function DeleteRolePermission($id)
    {
        $role = Role::findOrFail($id);
        
        if ($role) {
            $role->delete();
            
            $notification = array(
                "message" => "Role and its permissions deleted successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.role.permission')->with($notification);
        }
        else {
            $notification = array(
                "message" => "Role not found", 
                "alert-type" => "error"
            );
            return redirect()->back()->with($notification);
        }
    }

    public function EditAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $roles = Role::all();
        return view('admin.backend.pages.admin.edit_admin', compact('admin', "roles"));
    }

    public function EditPermission($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.backend.pages.permission.edit_permission', compact('permission'));
    }

    public function EditRole($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.backend.pages.role.edit_role', compact('role'));
    }

    public function EditRolePermission($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $permissionGroups = Admin::getPermissionGroups();

        return view('admin.backend.pages.rolesetup.edit_role_permission', compact('role', 'permissions', 'permissionGroups'));
    }

    public function ExportExcelPermission() {
        return Excel::download(new PermissionExport, 'permissions.xlsx');
    }

    public function ImportExcelPermission(Request $request) {
        Excel::import(new PermissionImport, $request->file('import_file'));
        
        $notification = array(
                "message" => "Permission imported successfully", 
                "alert-type" => "success"
            );
            return redirect()->back()->with($notification);
    }

    public function ImportPermission() {
        return view('admin.backend.pages.permission.import_permission');
    }

    public function StoreAdmin(Request $request) {
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->address = $request->address;
        $admin->password = Hash::make($request->password);
        $admin->role = "admin";
        $admin->status = "1";
        $admin->save();

        if($request->roles) {
            $role = Role::where('id', $request->roles)->where('guard_name', 'admin')->first();

            if($role) {
                $admin->assignRole($role->name);
            } else {
                return redirect()->back()->with('error', 'Role not found');
            }
        }

        $notification = array(
            "message" => "Admin created successfully", 
            "alert-type" => "success"
        );

        return redirect()->route('all.admins')->with($notification);
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

    public function StorePermissionRole(Request $request) {
        $data = array();
        $permissions = $request->permission;

        foreach($permissions as $key => $permission) {
            $data[] = [
                'role_id' => $request->role_id,
                'permission_id' => $permission
            ];
        }

        DB::table('role_has_permissions')->insert($data);

        $notification = array(
            "message" => "Permissions assigned to role successfully", 
            "alert-type" => "success"
        );
        return redirect()->route('all.role.permission')->with($notification);
    }

    public function StoreRole(Request $request) {
        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = 'admin';
        $role->save();

        $notification = array(
            "message" => "Role created successfully", 
            "alert-type" => "success"
        );

        return redirect()->route('all.roles')->with($notification);
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

    public function UpdateAdmin(Request $request) {
        $admin = Admin::findOrFail($request->id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->address = $request->address;
        $admin->role = "admin";
        $admin->status = "1";
        $admin->save();

        $admin->roles()->detach();

        if($request->roles) {
            $role = Role::where('id', $request->roles)->where('guard_name', 'admin')->first();

            if($role) {
                $admin->assignRole($role->name);
            } else {
                return redirect()->back()->with('error', 'Role not found');
            }
        }

        $notification = array(
            "message" => "Admin updated successfully", 
            "alert-type" => "success"
        );

        return redirect()->route('all.admins')->with($notification);
    }

    public function UpdateRole(Request $request) {
        $role = Role::findOrFail($request->id);
        $role->name = $request->name;
        $role->save();

        $notification = array(
            "message" => "Role updated successfully", 
            "alert-type" => "success"
        );

        return redirect()->route('all.roles')->with($notification);
    }

    public function UpdateRolePermission(Request $request, $id) {
        $role = Role::findOrFail($id);
        $permissions = $request->permission;

        if(!empty($permissions)) {
            $permissionNames = Permission::whereIn('id', $permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        }
        else {
            // If no permissions are selected, we can either detach all permissions or handle it as per your requirement
            // Here we will detach all permissions if none are selected
            $role->permissions()->detach();
        }

        $notification = array(
            "message" => "Role permissions updated successfully", 
            "alert-type" => "success"
        );

        return redirect()->route('all.role.permission')->with($notification);
    }
}
