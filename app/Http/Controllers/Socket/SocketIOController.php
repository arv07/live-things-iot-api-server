<?php

namespace App\Http\Controllers\Socket;

use App\Http\Controllers\Controller;
use App\Models\Device\Device;
use App\Models\Sensor\Relay;
use Illuminate\Http\Request;
use App\Models\User;

class SocketIOController extends Controller
{
    public function getDevice($device_token)
    {
        
        try {
            $device = Device::where('device_token', $device_token)->first();
            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $device,  'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'device does not exist or error in query', $th->getMessage(), 'levelNotication' => 2], 200);
        }
    }


    public function saveDeviceIdSocket(Request $request)
    {
        try {
            error_log($request->input('id_socket'));
            $device = Device::where('device_token', $request->input('device_token'))->first();
            $device->id_socket = $request->input('id_socket');
            $device->save();

            return response()->json(['state' => 'ok', 'message' => 'id socket saved',  'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'id socket was not saved', $th->getMessage(), 'levelNotication' => 2], 200);
        }
        

    }

    public function getDeviceUser($user_token, $id_device)
    {
        $user = User::where('user_token', $user_token)->first();
        $user = $user->with(['devices' => function ($query) use ($id_device){
            $query->where('id_device', $id_device);
        }])->get();
        return $user[0]->devices[0];
    }

    //Get the user info associated with a device
    public function getUserDevice($device_token)
    {
        try {
            $device = Device::where('device_token', $device_token)->first();
            $user = $device->user;
            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $user, 'levelNotication' => 1], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error queyring data', $th->getMessage(), 'levelNotication' => 2], 200);
        }
        
        
    }
}
