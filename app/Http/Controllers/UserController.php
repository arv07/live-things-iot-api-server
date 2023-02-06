<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        //Only apply for the methods indicates
        $this->middleware('can:users.index')->only('getUsers');
    }
    public function getUsers(Request $request)
    {   
        //OK
        //$users = User::with(['roles'])->get();//all_users_with_all_their_roles
        
        //$users = User::find(2);
        //$users = $users->getAllPermissions();
        //$users = User::all();
        
        //$user = User::getAllPermissions();
        $users = User::with('permissions')->get();//all_users_with_all_direct_permissions
        //$users = Role::all()->pluck('name');//$all_roles_in_database
        //$users = User::doesntHave('roles')->get();
        //$roles = Role::all();//get all roles

        //OK
        return response()->json(['state' => 'ok', 'message' => 'query ok', 'data' => $users, 'levelNotification' => '1'], 200);

        //return $users;
        
    }

    public function updateRoleUser(Request $request)
    {

        $user = User::find($request->input('id_user'));
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->revokePermissionTo($this->getAllPermissions());
        //$user->syncRoles($request->input('role'));
        $user->givePermissionTo($request->input('permissions'));
        $sql = $user->save();

        if($sql)
        {
            return response()->json(['state' => 'ok', 'message' => 'updated', 'sql' => $sql,'levelNotification' => '1'], 200);
        }
        else
        {
            return response()->json(['state' => 'error', 'message' => 'dont updated', 'sql' => $sql,'levelNotification' => '2'], 200);
        }

        return $request;        
        
    }

    public function getAuthenticatedUser()
    {
        $userId = Auth::user();
        $user = User::find($userId->id_user);
        //$user->getDirectPermissions();
        //$user->getPermissionsViaRoles();
        //return $data;
        return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $user, 'levelNotification' => '1'], 200);
    }

    public function getAllPermissions()
    {
        $permissions = array();
        $sql = DB::table('permissions')->select('permissions.name')->get();
        foreach($sql as $key => $item){ $permissions[$key] = $item->name; }
        return $permissions;
        
    }

    public function assignPermissions()
    {
        //$user = User::find(1);
        //$user->givePermissionTo('admin.users.index');
        $permissions = array();
        $sql = DB::table('permissions')->select('permissions.name')->get();

        foreach($sql as $key => $item)
        {
            //error_log($item->name);
            //error_log($key);
            $permissions[$key] = $item->name;
        }

        foreach($permissions as $item)
        {
            error_log($item);
        }

        //return 
    }
}
