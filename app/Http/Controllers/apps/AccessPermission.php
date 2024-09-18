<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

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
}
