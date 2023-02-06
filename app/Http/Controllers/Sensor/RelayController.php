<?php

namespace App\Http\Controllers\Sensor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RelayController extends Controller
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
                }, 'devices.sensors.relay' //call relationship
            ])->get();

            return response()->json(['state' => 'ok', 'message' => 'ok', 'data' => $events[0]->devices[0]->sensors[0]->relay[0], 'levelNotication' => 1], 200);
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
