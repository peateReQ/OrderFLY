<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLastLoginAt
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if (method_exists($event->user, 'save')) {
            $event->user->last_login_at = now();
            $event->user->save();
        }
        \App\Services\AuditLogger::log('Użytkownik zalogował się', [
            'user_id' => $event->user->getAuthIdentifier(),
            'email' => $event->user->email ?? ($event->user->getAuthIdentifierName() ? $event->user->{$event->user->getAuthIdentifierName()} : null),
            'ip' => request()->ip(),
        ]);
    }
}
