<?php

namespace App\Http\Controllers\Sensor\Fingerprint;

use App\Http\Controllers\Controller;
use App\Models\Sensor\Fingerprint\FingerprintUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Device\Device;
use App\Models\Sensor\Fingerprint\FingerprintEntry;

class FingerprintUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_device)
    {
        $idUser = Auth::user()->id_user;
        $user = User::find($idUser);
        try {
            $user = $user->with([
                'devices' => function ($query) use ($id_device) { //Passing parameters
                    $query->where('id_device', $id_device);
                },
                'devices.sensors.fingerprint.fingerprintUsers' //call relationship
            ])->get();

            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $user[0]->devices[0]->sensors[0]->fingerprint[0]->fingerprintUsers, 'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error querying data', 'sql' => $th->getMessage(), 'levelNotication' => 2], 200);
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

        $idUser = Auth::user()->id_user;
        $idDevice = $request->input('id_device');

        $fingerprintUser = new FingerprintUser([
            'name' => $request->input('name'),
            'fingerprint_code' => $request->input('fingerprint_code'),
            'state' => 'INACTIVE'
        ]);

        $user = User::find($idUser);
        try {
            $user = $user->with([
                'devices' => function ($query) use ($idDevice) { //Passing parameters
                    $query->where('id_device', $idDevice);
                },
                'devices.sensors.fingerprint' //call relationship
            ])->get();

            $sql = $user[0]->devices[0]->sensors[0]->fingerprint[0]->fingerprintUsers()->save($fingerprintUser);

            return response()->json(['state' => 'ok', 'message' => 'user created', 'sql' => $sql, 'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error creating user', 'sql' => $th->getMessage(), 'levelNotication' => 2], 200);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function changeStateUser(Request $request)
    {
        $idUser = Auth::user()->id_user;
        $user = User::find($idUser);
        $idDevice = $request->input('id_device');
        $idFingerprintUser = $request->input('id_fingerprint_user');
        try {
            $user = $user->with([
                'devices' => function ($query) use ($idDevice) { //Passing parameters
                    $query->where('id_device', $idDevice);
                },
                'devices.sensors.fingerprint.fingerprintUsers' //call relationship
            ])->get();

            $fingerprintUser = $user[0]->devices[0]->sensors[0]->fingerprint[0]->fingerprintUsers()->where('id_fingerprint_user', $idFingerprintUser)->first();
            $fingerprintUser->state = $request->input('state');
            $fingerprintUser->save();


            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $fingerprintUser, 'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error querying data', 'sql' => $th->getMessage(), 'levelNotication' => 2], 200);
        }
    }


    public function enrollEntry(Request $request)
    {
        try {

            $device = Device::where('device_token', $request->input('device_token'))->first();
            $fingerprintUser = $device->sensors[0]->fingerprint[0]->fingerprintUsers()->where('fingerprint_code', $request->input('fingerprint_code'))->first();

            $fingerprintEntry = new FingerprintEntry([
                'id_fingerprint_user' => $fingerprintUser->id_fingerprint_user
            ]);
            if ($fingerprintUser->state == 'ACTIVE') {
                $sql = $fingerprintUser->fingerprintEntries()->save($fingerprintEntry);
                return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $sql, 'levelNotication' => 1], 200);
            } else {
                return response()->json(['state' => 'error', 'message' => 'user is inactive', 'levelNotication' => 3], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error querying data', 'sql' => $th->getMessage(), 'levelNotication' => 2], 200);
        }
    }
}
