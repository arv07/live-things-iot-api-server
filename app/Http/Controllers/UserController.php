<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
* @OA\Info(title="API Usuarios", version="1.0")
*
* @OA\Server(url="http://192.168.1.103:8000")
*/

class UserController extends Controller
{
    public function __construct()
    {
        //Only apply for the methods indicates
        $this->middleware('can:users.index')->only('getUsers');
    }
    
   /**
        * @OA\Get(
        * path="/api/user/getUsers",
        * operationId="Register",
        * tags={"Register"},
        * summary="User Register",
        * description="User Register here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name","email", "password", "password_confirmation"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="email", type="text"),
        *               @OA\Property(property="password", type="password"),
        *               @OA\Property(property="password_confirmation", type="password")
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */
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
