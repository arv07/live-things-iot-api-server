<?php

namespace App\Http\Controllers\Sensor\Fingerprint;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device\Device;
use App\Models\Sensor\Fingerprint\Fingerprint;
use App\Models\Sensor\Fingerprint\FingerprintEntry;
use App\Models\Sensor\Fingerprint\FingerprintUser;
use Illuminate\Support\Facades\DB;

class FingerprintEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_device)
    {
        try {
            $device = Device::find($id_device);
            $fingerprintEntries = $device->select('fingerprint_users.name', 'fingerprint_entries.created_at', 'fingerprint_entries.id_fingerprint_entry')
                ->join('device_sensors', 'devices.id_device', '=', 'device_sensors.id_device')
                ->join('fingerprint_sensors', 'device_sensors.id_device_sensor', '=', 'fingerprint_sensors.id_device_sensor')
                ->join('fingerprint_users', 'fingerprint_sensors.id_fingerprint_sensor', '=', 'fingerprint_users.id_fingerprint_sensor')
                ->join('fingerprint_entries', 'fingerprint_users.id_fingerprint_user', '=', 'fingerprint_entries.id_fingerprint_user')
                ->where('devices.id_device', $id_device)
                ->orderBy('fingerprint_entries.created_at', 'desc')
                ->limit(20)
                ->get();

            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $fingerprintEntries, 'levelNotication' => 1], 200);
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
        //
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
}
