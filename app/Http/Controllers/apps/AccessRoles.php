<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class AccessRoles extends Controller
{
  public function index()
  {
    $roles = Role::withCount('users')->get();
    $path = public_path('assets\json\role-list.json');
    $obj_data = json_decode(file_get_contents($path));
    $obj_data->data = $roles;
    file_put_contents($path, json_encode($obj_data));
    return view('content.apps.app-access-roles', ["roles" => $roles]);
  }

  public function addRole(Request $request)
  {
    $listPermission = $_POST['permission'];
    try {
      $role = [];
      $role['name'] = $request->name;
      $role['guard_name'] = $request->guard_name;
      $newRole = Role::create($role);
      foreach ($listPermission as $item) {
        $permission = Permission::where('name', $item)->first();
        $permission_role = array('permission_id' => $permission->id,'role_id' => $newRole->id);;
        DB::table('role_has_permissions')->insert($permission_role);
      };
      return redirect(route('app-access-roles'));
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }

  public function editRole(Request $request)
  {
    try {
      $role = Role::find($request->id);
      $listPermission = $_POST['permission'];
      if (!empty($role)) {
        DB::update('update roles set name = ? guard_name = ? where id = ?',[$request->name,$request->guard_name,$request->id]);
        foreach ($listPermission as $item) {
          $permission = Permission::where('name', $item)->first();
          $existed = DB::table('role_has_permissions')
          ->where('permission_id', '=', $permission->id)
          ->where('role_id', '=', $role->id)
          ->get();
          if(empty($existed)) {
            $permission_role = array('permission_id' => $permission->id,'role_id' => $role->id);;
            DB::table('role_has_permissions')->insert($permission_role);
          }
        };
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
      if (!empty($role)) {
        return view('_partials._modals.modal-edit-role', compact('role'));
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
