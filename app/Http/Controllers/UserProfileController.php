<?php

namespace App\Http\Controllers;

use App\User;
use App\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function show(UserProfile $userProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function edit(UserProfile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // var_dump($request->links);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $app = env('ASSETS_URL');
            $file = $request->file('image');
            $id = uniqid();
            $name = $id . $file->getClientOriginalName();
            $path = $file->move(public_path('/images'), $name);
            $imagename = "$app/$name";
        } else {
            $imagename = User::with('id',$request->id)->with('profile')->first()->profile->image;
        }

        $profile = UserProfile::updateProfile($request->id, $request->company, $request->description, $request->email_description, $request->links, $imagename);
        return response()->json("Profile updated!", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserProfile  $userProfile
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}
