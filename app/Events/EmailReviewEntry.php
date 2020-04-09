<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\ReviewRequest;

class EmailReviewEntry
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($reviewRequest)
    {
        $client = $reviewRequest->client;
        $agent = User::where('id', $reviewRequest->agent->id)->with('profile')->first();
        $email = view('reviews.email')->with(['agent' => $agent, 'email' => $reviewRequest, 'client' => $client]);
        $client = new \GuzzleHttp\Client();
        $body = ['From' => 'eric@getagentreviews.com', 'To' => $reviewRequest->client->email, 'Subject' => 'Agent Reviews', 'HtmlBody' => "'$email'"];
        $response = $client->request('POST', 'https://api.postmarkapp.com/email', [
            'json' => $body,
            'TrackOpens' => true,
            'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json', 'X-Postmark-Server-Token' => env('POSTMARK_TOKEN')]
        ]);
        print_r($response);
  
        return response()->json('Email Sent Successfully!', 200);

    }
}
