<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device\Available\DeviceAvailable;
use App\Models\Device\Device;
use App\Models\Sensor\DeviceSensor;
use App\Models\Sensor\Fingerprint\Fingerprint;
use App\Models\Sensor\Relay;
use App\Models\Utils\Utils;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUser = Auth::user()->id_user;
        try {
            $user = User::find($idUser);
            $user = $user->with('devices')->get();
            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $user[0]->devices,  'levelNotification' => 1], 200);
            //return Auth::user()->id_user;
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error querying data', $th->getMessage(), 'levelNotification' => 2], 200);
        }
        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $device = new Device();
        $deviceAvailable = new DeviceAvailable();
        $utils = new Utils();

        /** Get user auth  and id*/
        $idUser = Auth::user()->id_user;

        /** find user authenticated */

        try {
            /** validate if device exist or is in use */
            if ($device->isDeviceInUse($request->input('internal_code'))) {
                error_log("Existe");
                return response()->json(['state' => 'warning', 'message' => 'device already in use', 'levelNotification' => 2], 200);
            } else if (!$deviceAvailable->deviceAvailableExist($request->input('internal_code'))) {
                return response()->json(['state' => 'warning', 'message' => 'code does not exist', 'levelNotification' => 2], 200);
            }


            /**Get data of device available */
            $deviceAvailable = DeviceAvailable::where('internal_code', $request->input('internal_code'))->first();
            //return $deviceAvailable;

            /** create device */
            DB::beginTransaction();
            $device = new Device([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'location' => $request->input('location'),
                'state' => 'INACTIVE',
                'device_token' => $utils->createRandomToken(20),
                'id_socket' => $utils->createRandomToken(12),
                'internal_code' => $deviceAvailable->internal_code,
                'reference' => $deviceAvailable->reference,
                'version' => $deviceAvailable->version,

            ]);
            $user = User::find($idUser);
            $device = $user->devices()->save($device); //call relationship and save the device. When save it returns all inserted register including id generated
            //return $device;


            /* create device sensors */
            foreach ($deviceAvailable->sensorsAvailables as $sensor) //laod relationship and loop for all sensors
            {
                error_log($sensor->sensor);
                //Create the sensors
                $deviceSensor = new DeviceSensor(['sensors' => $sensor->sensor]); //Create sensors that belongs to the device
                $deviceSensor = $device->sensors()->save($deviceSensor); //save sensor. When save it returns all inserted register including id generated

                if ($sensor->sensor == 'fingerprint') {
                    //Create the sensor in the appropiate table
                    $fingerprint = new Fingerprint([
                        'reference' => $sensor->reference
                    ]);
                    $fingerprint = $deviceSensor->fingerprint()->save($fingerprint); //save fingerprint
                }

                if ($sensor->sensor == 'relay') {
                    $relay = new Relay([
                        'state' => 0
                    ]);

                    $relay = $deviceSensor->relay()->save($relay); //save relay
                }
            }

            DB::commit();
            return response()->json(['state' => 'ok', 'message' => 'device created', 'levelNotification' => 1], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['state' => 'error', 'message' => 'error creating device', 'levelNotification' => 2, 'exception' => $th], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idUser = Auth::user()->id_user;
        try {
            $user = User::find($idUser);
            $user = $user->with(['devices' => function ($query) use ($id){
                $query->where('id_device', $id);
            }])->get();
            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $user[0]->devices[0],  'levelNotification' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'device does not exist or error in query', $th->getMessage(), 'levelNotification' => 2], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_device)
    {
        $idUser = Auth::user()->id_user;
        try {
            $user = User::find($idUser);
            $device = $user->with(['devices' => function ($query) use ($id_device){
                $query->where('id_device', $id_device);
            }])->get();

            $device = $device[0]->devices[0];
            $device->name = $request->input('name');
            $device->description = $request->input('description');
            $device->location = $request->input('location');
            $sql = $device->save();

            return response()->json(['state' => 'ok', 'message' => 'ok', 'sql' => $sql,  'levelNotification' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'device does not exist or error in query', $th->getMessage(), 'levelNotification' => 2], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_device)
    {
        try {
            $idUser = Auth::user()->id_user;
            $user = User::find($idUser);
            $device = $user->with(['devices' => function ($query) use ($id_device){
                $query->where('id_device', $id_device);
            }])->get();
            $sql = $device[0]->devices[0]->delete();
            //$device = Device::find($id_device);
            return response()->json(['state' => 'ok', 'message' => 'ok', 'sql' => $sql,  'levelNotification' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'device does not exist or error in query', $th->getMessage(), 'levelNotification' => 2], 200);
        }
        

    }


    
}
