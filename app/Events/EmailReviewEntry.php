<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Agents;

class EmailReviewEntry
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $data = ['email' => $email, 'agent' => User::find(1)->first()];

    \Mail::send('reviews.email', $data, function ($message) use($email, $agent) {
        $message->subject('Leave a review about ' . $agent->name);
        $message->from($agent->email);
        $message->to($email->email);
    });

    }
}
