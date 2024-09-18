<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\RoleHasPermission;

class AccessRoles extends Controller
{
  public function index()
  {
    $roles = Role::all();
    $path = public_path('assets\json\role-list.json');
    $obj_data = json_decode(file_get_contents($path));
    $obj_data->data = $roles;
    file_put_contents($path, json_encode($obj_data));
    return view('content.apps.app-access-roles', ["roles" => $roles]);
  }

  public function addRole(Request $request)
  {
    $listPermission = $request->permission;
    $permission_role = [];
    try {
      $role = [];
      $role['name'] = $request->name;
      $role['guard_name'] = $request->guard_name;
      $newRole = Role::create($role);
      foreach ($listPermission as $item) {
        $permission = Permission::where('name', $item)->first();
        array_push($permission_role, ['permission_id'=>$permission->id, 'role_id'=>$newRole->id]);
      };
      RoleHasPermission::query()->insert($permission_role);
      return redirect(route('app-access-roles'));
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }

  public function editRole(Request $request)
  {
    try {
      $role = Role::find($request->id);
      $permissionsID = array_map(
        function($value) { return (int)$value; },
        $request->input('permission')
      );
      if (!empty($role)) {
        // DB::update('update roles set name = ? guard_name = ? where id = ?',[$request->name,$request->guard_name,$request->id]);
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $role->save();
        $role->syncPermissions($permissionsID);
        return redirect(route('app-access-roles'));
      }
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }

  public function getRole(Request $request)
  {
    try {
      $role = Role::find($request->id);
      $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$request->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
      if (!empty($role)) {
        return view('_partials._modals.modal-edit-role', compact('role', 'rolePermissions'));
      }
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }

  public function deleteRole(Request $request)
  {
    try {
      $role = Role::find($request->id);
      $permissions = DB::table('role_has_permissions')
          ->where('role_id', '=', $role->id)
          ->get();

      foreach ($permissions as $permission) {
        $role->revokePermissionTo($permission);
      }
      
      $role->delete();
        return response()->json([
          'message' => 'Delete successfully',
      ]);
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }
}
