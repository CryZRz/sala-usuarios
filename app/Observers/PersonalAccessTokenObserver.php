<?php

namespace App\Observers;

use Illuminate\Support\Str;
use Laravel\Passport\Token;

class PersonalAccessTokenObserver
{
    /**
     * Handle the PersonalAccessToken "created" event.
     */
    public function creating(Token $personalAccessToken)
    {
        if (empty($personalAccessToken->uuid)) {
            $personalAccessToken->uuid = (string) Str::uuid();
        }
    }

    public function created(Token $personalAccessToken): void
    {

    }

    /**
     * Handle the PersonalAccessToken "updated" event.
     */
    public function updated(Token $personalAccessToken): void
    {
        //
    }

    /**
     * Handle the PersonalAccessToken "deleted" event.
     */
    public function deleted(Token $personalAccessToken): void
    {
        //
    }

    /**
     * Handle the PersonalAccessToken "restored" event.
     */
    public function restored(Token $personalAccessToken): void
    {
        //
    }

    /**
     * Handle the PersonalAccessToken "force deleted" event.
     */
    public function forceDeleted(Token $personalAccessToken): void
    {
        //
    }
}
