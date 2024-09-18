<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AccessPermission extends Controller
{
  public function index()
  {
    $permissions = Permission::all();
    $path = public_path('assets\json\permissions-list.json');
    $obj_data = json_decode(file_get_contents($path));
    $obj_data->data = $permissions;
    file_put_contents($path, json_encode($obj_data));
    return view('content.apps.app-access-permission', ["permissions" => $permissions]);
  }

  public function fetchPermissions()
  {
    $permissions = Permission::all();
    $path = public_path('assets\json\permissions-list.json');
    $obj_data = json_decode(file_get_contents($path));
    $obj_data->data = $permissions;
    // file_put_contents($path, json_encode($obj_data));
    return json_encode($obj_data);
  }

  public function addPermission(Request $request)
  {
    try {
      $permission = ['name'=>$request->name];
      $newPermission = Permission::query()->create($permission);
      return redirect(route('app-access-permission'));
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }

  public function editPermission(Request $request)
  {
    try {
      $permission = Permission::find($request->id);
      if (!empty($permission)) {
        // DB::update('update roles set name = ? guard_name = ? where id = ?',[$request->name,$request->guard_name,$request->id]);
        $permission->name = $request->name;
        $permission->save();
        return redirect(route('app-access-permission'));
      }
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }

  public function getPermission(Request $request)
  {
    try {
      $permission = Permission::find($request->id);
      $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.permission_id",$permission->id)
        ->pluck('role_has_permissions.role_id','role_has_permissions.role_id')
        ->all();
      if (!empty($permission)) {
        return view('_partials._modals.modal-edit-permission', compact('permission', 'rolePermissions'));
      }
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }

  public function deletePermission(Request $request)
  {
    try {
      $permission = Permission::find($request->id);
      $permissions = DB::table('role_has_permissions')
        ->where('permission_id', '=', $permission->id)
        ->get();
      foreach ($permissions as $item) {
        $role = Role::find($item->role_id);
        $role->revokePermissionTo($item);
      }
      
      $permission->delete();
        return response()->json([
          'message' => 'Delete successfully',
      ]);
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }
}
