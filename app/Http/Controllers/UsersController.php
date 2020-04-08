<?php

namespace App\Http\Controllers;

use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return
        $user = User::with('profile')->paginate(60);
    }

    public function login(Request $request)
    {
        $request->validate([
          'email' => 'required|email',
          'password' => 'required|min:8'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = Auth::user()->createToken('authToken')->accessToken;
            $user = User::where('id', Auth::user()->id)->with('profile')->first();
            return response()->json(['user' => $user, 'token' => $token], 200);
        } else {
            return response()->json('Invalid Credentials', 401);
        }
    }
    public function getReviews($id) 
    {
        $reviews = User::where('id', $id)->first()->reviewRequest;
        return $reviews;
    }


    /**
     * Store a newly created resource in storage, in other words, register.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique',
            'password' => 'required|min:8',
            'number' => 'required|phone',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->number
        ]);
        UserProfile::createProfile(
            $user->id,
            $request->company,
            '',
            '',
            '',
            ''
        );
        $token = $user->createToken('authToken')->accessToken;
        $newUser = User::where('id', $user->id)->with('profile')->first();

        return response()->json(['user' => $newUser, 'token' => $token], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->with('profile')->first();
        json_encode($user->profile->links);
        return response()->json($user, 200);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }

    public function getUserByToken()
    {
        $id = auth()->user()->id;
        $user =  User::where('id', $id)->with('profile')->first();
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }
}
