<?php

namespace App\Http\Controllers;

use App\User;
use App\ReviewRequest;
use GuzzleHttp\Client;
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
        return ReviewRequest::with('agent')->with('client')->paginate(20);
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
            'agent_id' => $request->agent,
            'client_id' => $request->client,
            'email_sent' => date("Y-m-d H:i:s"),
        ]);
        event(new EmailReviewEntry($reviewRequest));
        return response()->json($reviewRequest, 200);
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
        if ($request->has('email_sent')) {
            ReviewRequest::where('id', $id)->update(['email_sent' => date('Y-m-d H:i:s')]);
            $review = ReviewRequest::where('id', $id)->with('agent')->with('client')->first();
            event(new EmailReviewEntry($review));
            return $review;
        }
        if ($request->has('link_clicked')) {
            ReviewRequest::where('id', $id)->update(['link_clicked' => date('Y-m-d H:i:s')]);
            $review = ReviewRequest::where('id', $id)->with('agent')->with('client')->first();
            return $review;
        }
        if ($request->has('star_rating_completed')) {
            ReviewRequest::where('id', $id)->update([
                'star_rating_completed' => date('Y-m-d H:i:s'),
                'star_rating' => $request->star_rating
            ]);
            $review = ReviewRequest::where('id', $id)->with('agent')->with('client')->first();
            return $review;
        }
        if ($request->has('feedback_completed')) {
            ReviewRequest::where('id', $id)->update([
                'feedback_completed' => date('Y-m-d H:i:s'),
                'feedback' => $request->feedback
            ]);
            $review = ReviewRequest::where('id', $id)->with('agent')->with('client')->first();
            return $review;
        }
        if ($request->has('external_review_completed')) {
            ReviewRequest::where('id', $id)->update([
                'external_review_completed' => date('Y-m-d H:i:s'),
                'external_link_clicked' => date('Y-m-d H:i:s')
            ]);
            $review = ReviewRequest::where('id', $id)->with('agent')->with('client')->first();
            return $review;
        }
    }
}
