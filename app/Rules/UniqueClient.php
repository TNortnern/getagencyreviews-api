<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class UniqueClient implements Rule
{
    public $value;
    public $agent;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($value, $agent)
    {
        $this->value = $value;
        $this->agent = $agent;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $clients = User::clients($this->agent);
        $exists = false;
        foreach ($clients as $reviewItem) {
            if ($reviewItem->client->email === $this->value) {
                $exists = true;
                break;
            }
        }
        return !$exists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "You already have a client with an email of $this->value";
    }
}
