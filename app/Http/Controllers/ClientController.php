<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use App\ReviewRequest;
use App\Rules\UniqueClient;
use Illuminate\Http\Request;
use Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::paginate(10);
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
            'email' => ['email', new UniqueClient($request->email, $request->agent)],
            'phone_number' => 'phone'
        ]);
       
        $newClient = Client::create([
            'email' => $request->email,
            'name' => $request->name,
            'phone_number' => $request->phone_number
        ]);
        $reviewRequest = ReviewRequest::create([
            'agent_id' => $request->agent,
            'client_id' => $newClient->id,
        ]);
        $reviewItem = ReviewRequest::find($reviewRequest->id);
        $reviewItem->client = $newClient;

        return $reviewItem;
    }
    public function bulkStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
    'clients.*.email' => 'email',
    'clients.*.name' => 'required',
    'clients.*.phone_number' => 'phone',
    ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $arrayOfFailed = [];
        $arrayOfSuccess = [];
        foreach ($request->clients as $client) {
            $isUnique = User::isUnique($client['email'], $request->agent);
            if (!$isUnique) {
                array_push($arrayOfFailed, $client);
            } else {
                $newClient = Client::create([
                'email' => $client['email'],
                'name' => $client['name'],
                'phone_number' => $client['phone_number']
            ]);
                $reviewRequest = ReviewRequest::create([
                'agent_id' => $request->agent,
                'client_id' => $newClient->id,
            ]);
                $reviewItem = ReviewRequest::find($reviewRequest->id);
                $reviewItem->client = $newClient;
                array_push($arrayOfSuccess, $reviewItem);
            }
        }
        return response()->json(['failed' => $arrayOfFailed, 'success' => $arrayOfSuccess], 200);
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
    public function destroy($id)
    {
        $client = Client::where('id', $id);
        $delete = $client->update([
            'isDeleted' => 1
        ]);
        if ($delete) {
            return response()->json(['client' => $client->first(), 'msg' => 'deleted!'], 200);
        }
    }
}
