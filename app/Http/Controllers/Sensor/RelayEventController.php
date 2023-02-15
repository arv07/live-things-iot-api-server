<?php

namespace App\Http\Controllers\Sensor;

use App\Http\Controllers\Controller;
use App\Models\Device\Device;
use App\Models\Sensor\RelayEvent;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Sensor\Relay;

class RelayEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_device)
    {
        $idUser = Auth::user()->id_user;


        try {
            $user = User::find($idUser);
            $events = $user->with([
                'devices' => function ($query) use ($id_device) { //Passing parameters
                    $query->where('id_device', $id_device);
                }, 'devices.sensors.relay.relayEvents' //call relationship
            ])->get();

            $events = $events[0]->devices[0]->sensors[0]->relay[0]->relayEvents()->orderBy('created_at', 'desc')->limit(10)->get();
            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $events, 'levelNotication' => 1], 200);
            //return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $events[0]->devices[0]->sensors[0]->relay[0]->relayEvents, 'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error querying data', 'sql' => $th->getMessage(), 'levelNotication' => 2], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     * To register the new state of the relay
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get id user authenticated
        //$idUser = 1;
        $idUser = Auth::user()->id_user;
        $idDevice = $request->input('id_device');
        //Create event
        $relayEvent = new RelayEvent([
            'state' => $request->input('state')
        ]);

        $relay = new Relay([
            'state' => $request->input('state')
        ]);

        $user = User::find($idUser);

        try {
            /* $user = $user->with([
                'devices' => function ($query) use ($idDevice) { //Passing parameters
                    $query->where('id_device', $idDevice);
                },
                'devices.sensors.relay.relayEvents' //call relationship
                //'devices.sensors.relay'
            ])->get(); */
            $user = $user->with([
                'devices' => function ($query) use ($idDevice) { //Passing parameters
                    $query->where('id_device', $idDevice);
                },
                'devices.sensors' => function ($query) { //Passing parameters
                    $query->where('sensors', 'relay');
                },
                'devices.sensors.relay.relayEvents' //call relationship
            ])->get();


            //Create new event
            $sql = $user[0]->devices[0]->sensors[0]->relay[0]->relayEvents()->save($relayEvent);

            //Update state in relay
            $sql2 = $user[0]->devices[0]->sensors[0]->relay[0];
            $sql2->state = $request->input('state');
            $sql2->save();

            return response()->json(['state' => 'ok', 'message' => 'event created', 'sql' => $sql, 'levelNotication' => 1], 200);
            //return $user;
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error creating event', 'sql' => $th->getMessage(), 'levelNotication' => 2], 200);
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

    public function changeState(Request $request)
    {
        try {
            $device = Device::where('device_token', $request->input('device_token'))->first();
            $device = $device->with([
                'sensors' => function ($query) { //Passing parameters
                    $query->where('sensors', 'relay');
                },
                'sensors.relay' //call relationship
            ])->get();

            //Update state in relay
            $sql2 = $device[0]->sensors[0]->relay[0];
            $sql2->state = $request->input('state');
            $sql2->save();

            return response()->json(['state' => 'ok', 'message' => 'event created', 'sql' => $device, 'levelNotication' => 1], 200);
        } catch (\Throwable $th) {
            return response()->json(['state' => 'error', 'message' => 'error creating event', 'sql' => $th->getMessage(), 'levelNotication' => 2], 200);
        }
    }


    /* $teams = App\Team::with([
            'portfolios' => function ($query) use ($user) {
                // Only include portfolios where...
                $query->whereHas('wallets', function ($query) use ($user) {
                    // ...there are wallets...
                    $query->whereHas('transactions', function ($query) {
                        // ...with pending transactions...
                        $query->whereStatus('pending');
                    });
        
                    // ...to be received by the given user.
                    $query->where('walletable_id', $user->id);
                    $query->where('walletable_type', App\User::class);
                });
            },
            'portfolios.wallets' => function ($query) use ($user) {
                // Second layer of constraints
                $query->whereHas('transactions', function ($query) {
                    $query->whereStatus('pending');
                });
        
                $query->where('walletable_id', $user->id);
                $query->where('walletable_type', App\User::class);
            },
            'portfolios.wallets.transactions' => function ($query) {
                // Third and final layer of constraints
                $query->whereStatus('pending');
            },
        ])->get(); */
}
