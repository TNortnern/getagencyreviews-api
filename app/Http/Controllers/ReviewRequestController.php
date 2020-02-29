<?php

namespace App\Http\Controllers;

use App\ReviewRequest;
use Illuminate\Http\Request;
use App\Events\EmailReviewEntry;

class ReviewRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReviewRequest::with('agent')->paginate(20);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reviewRequest = ReviewRequest::create([
            'agent' => $request->agent,
            'client_email' => $request->client_email,
            'client_name' => $request->client_name,
            'email_sent' => date("Y-m-d H:i:s"),
        ]);
        event(new EmailReviewEntry($reviewRequest));
        return $reviewRequest;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReviewRequest  $reviewRequest
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = ReviewRequest::where('id', $id)->with('agent')->first();
        return $review;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReviewRequest  $reviewRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('link_clicked')) {
            ReviewRequest::where('id', $id)->update(['link_clicked' => date('Y-m-d H:i:s')]);
            return response()->json('Updated link clicked' . $id, 200);
        }
        if ($request->has('star_rating_completed')) {
            ReviewRequest::where('id', $id)->update([
                'star_rating_completed' => date('Y-m-d H:i:s'),
                'star_rating' => $request->star_rating
            ]);
            return response()->json('Updated rating' . $id, 200);
        }
        if ($request->has('feedback_completed')) {
            ReviewRequest::where('id', $id)->update([
                'feedback_completed' => date('Y-m-d H:i:s'),
                'feedback' => $request->feedback
            ]);
            return response()->json('Updated feedback' . $id, 200);
        }
        if ($request->has('external_review_completed')) {
            ReviewRequest::where('id', $id)->update([
                'external_review_completed' => date('Y-m-d H:i:s'),
                'external_link_clicked' => date('Y-m-d H:i:s')
            ]);
            return response()->json('Updated external' . $id, 200);
        }
    }
}
