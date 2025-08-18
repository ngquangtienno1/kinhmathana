<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ClientResetPassword extends ResetPasswordNotification
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $url = url(route('client.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return $this->buildMailMessage($url);
    }
}
