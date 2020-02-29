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
        $email = $reviewRequest;
        $agent = User::orderBy('id', 'DESC')->where('id', $reviewRequest->agent)->first();
        $data = ['email' => $email, 'agent' => $agent];

    \Mail::send('reviews.email', $data, function ($message) use($email, $agent) {
        $message->subject('Leave a review about ' . $agent->name);
        $message->from($agent->email);
        $message->to($email->client_email);
    });

    }
}
