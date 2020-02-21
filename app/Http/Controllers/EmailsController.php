<?php

namespace App\Http\Controllers;

use App\Emails;
use Illuminate\Http\Request;
use App\Events\EmailReviewEntry;

class EmailsController extends Controller
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
        $email = Emails::create(['email' => $request->email]);
        event(new EmailReviewEntry($email));
        return response()->json($email, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $email = Emails::find($id);
        return response()->json($email, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function edit(Emails $emails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emails $emails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emails  $emails
     * @return \Illuminate\Http\Response
     */
    public function destroy(Emails $emails)
    {
        //
    }
}
