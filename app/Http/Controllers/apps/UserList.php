<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserList extends Controller
{
  use HasFactory, TwoFactorAuthenticatable;
  public function index()
  {
    $users = User::all();
    foreach ($users as $user) {
      $role = [];
      $roles = User::select('roles.name')
      ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
      ->join('roles', 'roles.id', 'model_has_roles.role_id')
      ->where('users.id', $user->id)->get();
      $user['role'] = $roles;
    }
    $path = public_path('assets\json\user-list.json');
    $obj_data = json_decode(file_get_contents($path));
    $obj_data->data = $users;
    file_put_contents($path, json_encode($obj_data));
    return view('content.apps.app-user-list');
  }

  public function create(Request $request)
  {
    $user = [];
    $user['name'] = $request->name;
    $user['email'] = $request->email;
    $user['password'] = Hash::make('password');
    $newUser = User::create($user);
    $newUser->assignRole($request->role);
    return redirect(route('app-user-list'));
  }

  public function edit(Request $request)
  {
    try {
      $user = User::find($request->id);
      $roles = $request->role;
      if (!empty($user)) {
        // DB::update('update roles set name = ? guard_name = ? where id = ?',[$request->name,$request->guard_name,$request->id]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        foreach ($roles as $role) {
          if(!$user->hasRole($role)) {
            $user->assignRole($role);
          }
        }
        return redirect(route('app-user-list'));
      }
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }

  public function delete(Request $request)
  {
    try {
      $role = User::find($request->id);
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

  public function get(Request $request)
  {
    try {
      $user = User::find($request->id);
      $roles = DB::table("model_has_roles")->where("model_has_roles.model_id",$request->id)
      ->pluck('model_has_roles.role_id','model_has_roles.role_id')
      ->all();
      if (!empty($user)) {
        return view('_partials._modals.modal-edit-user', compact('user', 'roles'));
      }
    } catch (\Exception $e) {
      \Log::info($e->getMessage());
    }
  }
}
