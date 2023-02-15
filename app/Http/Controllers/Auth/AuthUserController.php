<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Auth\AuthMail;
use App\Models\Device\Device;
use App\Models\Utils\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthUserController extends Controller
{
    /*to use in login*/
    public function create(RegisterRequest $request)
    {
        $mail = new AuthMail;
        $utils = new Utils;

    //try {
        $user = new User;
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->user_token = $utils->createRandomToken(30);
        $user->id_socket = $utils->createRandomToken(30);
        $user->socket_room = $utils->createRandomToken(15);

        $user->password = Hash::make($request->input('password'));            
        $user->hash_validate_email = $utils->createRandomToken(30);

        $sql = $user->save();

        if($sql)
        {
            //Send email to confirm email
            //$mail->sendConfirmEmail($request->input('email'), $hash, $password);
            return response()->json(['state' => 'ok', 'message' => 'user created', 'levelNotication' => 1], 201);
        }
        else {
            return response()->json(['state' => 'error', 'message' => 'user was not created', 'levelNotication' => 2], 200);
        }

        
    }

    /*To use inside the app*/
    public function createUser(RegisterRequest $request)
    {
        $mail = new AuthMail;
        $utils = new Utils;
        $hash = $utils->createRandomToken(32);
        $password = $utils->createRandomToken(10);
    //try {
        $user = new User;
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($password);
      
        $sql = $user->save();

        $sql = true;
        if($sql)
        {
            $msg = $mail->sendConfirmEmail($request->input('email'), $hash, $password);
            error_log($msg);
            if($msg == 'send')
            {
                return response()->json(['state' => 'ok', 'message' => 'user created', 'levelNotification' => '1'], 200);
            }
            else{
                return response()->json(['state' => 'error', 'message' => 'error sending email', 'levelNotification' => '2'], 200);
            }
            
        }
        else {
            
        }
            
    }


    //Create user for mobile
     /**
        * @OA\Post(
        * path="/api/userMobile/create",
        * operationId="Mobile Register",
        * tags={"Register"},
        * summary="User Register",
        * description="User Register here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name","last_name","email", "password", "password_confirmation"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="last_name", type="text"),
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
    public function createUserMobile(RegisterRequest $request)
    {
        $utils = new Utils;
        $user = new User;
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->user_token = $utils->createRandomToken(30);
        $user->socket_room = $utils->createRandomToken(15);
        $user->hash_validate_email = $utils->createRandomToken(30);
        //Create first dummy token for socket
        $user->id_socket = $utils->createRandomToken(20);
        $sql = $user->save();

        if($sql)
        {
            //Create a token for user
        $token = $user->createToken('auth_token')->plainTextToken;


        return response()->json([
            'state' => 'ok',
            'message' => 'saved',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'levelNotification' => '1',
            $user
        ]);
        }
        else {
            return response()->json([
                'state' => 'error',
                'message' => 'user not was created',
                'levelNotification' => '2',
                $user
            ]); 
        }

    }


    public function loginMobile(Request $request)
    {
        //$user = Auth::user();

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'state' => 'error',
                'message' => 'email or password incorrect',
                'levelNotification' => '2',
                //$user
            ]); 
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        //error_log($user->user_token);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'state' => 'ok',
            'message' => 'authenticated',
            'levelNotification' => '1',
            'user_token' => $user->user_token,
            'access_token' => $token,
            'token_type' => 'Bearer'

        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $sql = DB::table('users')->where('email', $request->input('email'))->first();

        error_log($sql != '');

        if($sql != '')
        {
            if($sql->email_verified_at  != null)
            {
                if (Auth::attempt($credentials)) {
                    // Authentication passed...
                    $authuser = auth()->user();
                    //return response()->json(['message' => 'Login successful'], 200);
                    return response()->json(['state' => 'ok', 'message' => 'Login successful', 'levelNotification' => '1'], 200);
                    //return response()->json($authuser, 200);
                } else {
                    //return response()->json(['error' => 'Invalid email or password'], 401);
                    return response()->json(['state' => 'error', 'message' => 'Invalid email or password', 'levelNotification' => '2'], 401);
                    //return response()->json(['error' => 'email o contraseña invalida'], 401);
                }
            }
            else{
                //return response()->json(['error' => 'Email is not validated'], 401);
                return response()->json(['state' => 'error', 'message' => 'Email is not validated', 'levelNotification' => '2'], 401);
            }
            
            
        }
        else {
            return response()->json(['error' => 'Email dont exist'], 401);
        }

        
    }


    public function logout(Request $request)
    {
        //return Auth::logout();
        //return Auth::user()->token();
        return $request->user()->currentAccessToken()->delete();
    }

    public function validateEmail($hash = null)
    {
        $sql = DB::table('users')->where('hash_validate_email', $hash)->first();

        if($sql)
        {
            User::where('hash_validate_email', $hash)->update(['email_verified_at' => date("Y-m-d h:i:s")]);
            return view('emails.EmailValidated');
        }
        else {
            return 'No se puedo validar';
        }

        
    }


    public function changePassword(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $sql = DB::table('users')->where('email', $request->input('email'))->first();

        error_log($sql != '');

        if($sql != '')
        {
            if($sql->email_verified_at  != null)
            {
                if (Auth::attempt($credentials)) {
                    // Authentication passed...
                    $authuser = auth()->user();

                    if(User::where('email', $request->input('email'))->update(['password' => Hash::make($request->input('new_password'))]))
                    {
                        return response()->json(['message' => 'Password changed successful'], 200);
                    }                    
                    //return response()->json($authuser, 200);
                } else {
                    return response()->json(['error' => 'Invalid password'], 401);
                    //return response()->json(['error' => 'email o contraseña invalida'], 401);
                }
            }
            else{
                return response()->json(['error' => 'Email is not validated'], 401);
            }
            
        }
        else {
            return response()->json(['error' => 'Email dont exist'], 401);
        }

    }

    protected function isAuthenticated()
    {
        try {
            return Auth::check();
        } catch (\Throwable $th) {
            return response()->json(['state' => 'ok', 'message' => 'ok', 'levelNotification' => '1'], 200);
        }
        
    }


    public function validateUserToken($user_token)
    {
        try {
            $userExist = false;
            $user = User::where('user_token', $user_token)->get();
            $user->count() != 0 ? $userExist = true : $userExist = false;
            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $userExist, 'levelNotication' => 1], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error validating', 'levelNotication' => 2], 200);
        }
        
    }

    //Save id socket generated by socket io
    public function saveIdSocket(Request $request)
    {
        try {
            $user = User::where('user_token', $request->input('user_token'))->first();
            $user->id_socket = $request->input('id_socket');
            $user->save();
            
            return response()->json(['state' => 'ok', 'message' => 'id socket saved',  'levelNotication' => 1], 200);

        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'id socket was not saved', 'levelNotication' => 2], 200);
        }
        
    }

    public function getSocketRoom($user_token)
    {   
        try {
            $user = User::where('user_token', $user_token)->first();

            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $user->socket_room, 'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error querying data', $th->getMessage(), 'levelNotication' => 2], 200);
        }
    }

    public function getUserToken($device_token)
    {
        try {
            $device = Device::where('device_token', $device_token)->first();
            //$device = Device::find(3);
            //return $device->user->user_token;
            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $device->user->user_token, 'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error querying data', $th->getMessage(), 'levelNotication' => 2], 200);
        }
    }

    
}
