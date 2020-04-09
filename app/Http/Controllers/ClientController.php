<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use App\ReviewRequest;
use App\Rules\UniqueClient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Clients::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['email', new UniqueClient($request->email)],
            'phone_number' => 'phone'
        ]);
        $clients = User::find($request->agent)->clients;
        $exists = false;
        foreach ($clients as $client) {
            if ($client->email === $request->email) {
                $exists = true;
                break;
            }
        }
        if ($exists) {
            return response()->json(['data' => "errors"], 200);
        }
        return response()->json($exists, 200);
        $newClient = Client::firstOrCreate([
            'email' => $request->email,
            'name' => $request->name,
            'phone_number' => $request->phone_number
        ]);
        $reviewRequest = ReviewRequest::firstOrCreate([
            'agent_id' => $request->agent,
            'client_id' => $newClient->id,
        ]);

        return $newClient;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $updatedClient = Client::where('id', $id)->update($request->all());
        return response()->json(['msg' => 'Success', 'id' => $updatedClient]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
