<?php

namespace App\Http\Controllers\Sensor\Movement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MovementController extends Controller
{
    public function index($id_device)
    {
        $idUser = Auth::user()->id_user;
        try {
            $user = User::find($idUser);
            $user = $user->with([
                'devices' => function ($query) use ($id_device) { //Passing parameters
                    $query->where('id_device', $id_device);
                },
                'devices.sensors' => function ($query) { //Passing parameters
                    $query->where('sensors', 'movement');
                },
                'devices.sensors.movement' //call relationship
            ])->get();

             $movementSensor = $user[0]->devices[0]->sensors[0]->movement[0];
            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $movementSensor, 'levelNotication' => 1], 200);
            //return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $events[0]->devices[0]->sensors[0]->relay[0]->relayEvents, 'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error querying data', 'sql' => $th->getMessage(), 'levelNotication' => 2], 200);
        }
    }

    public function update(Request $request, $idDevice)
    {

        try {
            $idUser = Auth::user()->id_user;
            $user = User::find($idUser);
            $user = $user->with([
                'devices' => function ($query) use ($idDevice) { //Passing parameters
                    $query->where('id_device', $idDevice);
                },
                'devices.sensors' => function ($query) { //Passing parameters
                    $query->where('sensors', 'movement');
                },
                'devices.sensors.movement' //call relationship
            ])->get();

            $device = $user[0]->devices[0]->sensors[0]->movement[0];
            $device->state = $request->input('state');
            $device->save();
            
            return response()->json(['state' => 'ok', 'message' => 'event created', 'sql' => $device, 'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return response()->json(['state' => 'error', 'message' => 'error creating event', 'sql' => $th->getMessage(), 'levelNotication' => 2], 200);
        }
    }
}
