<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Role;
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
    try {
      $role = Role::create($request->all());
      if (!empty($role)) {
        return redirect(route('app-access-roles'));
      }
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }

  public function editRole(Request $request)
  {
    try {
      $role = Role::find($request->id);
      if (!empty($role)) {
        $role['name'] = $request->name;
        $role['display_name'] = $request->display_name;
        $role['description'] = $request->description;
        $role->save();
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
        return view('_partials._modals.modal-edit-role', ["role" => $role]);
      }
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }
}
