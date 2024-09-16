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
    $path = public_path('assets\json\user-list.json');
    $obj_data = json_decode(file_get_contents($path));
    $obj_data->data = $roles;
    file_put_contents($path, json_encode($obj_data));
    return view('content.apps.app-access-roles', ["roles" => $roles]);
  }

  public function addRole(Request $request)
  {
    echo ("$request->name");
    try {
      $role = Role::create($request->all());
      if (!empty($role)) {
        // $roles = Role::withCount('users')->get();
        // $path = public_path('assets\json\user-list.json');
        // $obj_data = json_decode(file_get_contents($path));
        // $obj_data->data = $roles;
        // file_put_contents($path, json_encode($obj_data));
        // return view('content.apps.app-access-roles', ["roles" => $roles]);
        return redirect($this->index());
      }
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }
}
