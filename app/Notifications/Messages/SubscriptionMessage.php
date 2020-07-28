<?php

namespace App\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage;


class SubscriptionMessage extends MailMessage
{
    public $email;


    public function __construct($email) {
        $this->email = $email;
    }

    /**
     * Get an array representation of the message.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'level' => $this->level,
            'subject' => $this->subject,
            'greeting' => $this->greeting,
            'salutation' => $this->salutation,
            'introLines' => $this->introLines,
            'outroLines' => $this->outroLines,
            'actionText' => $this->actionText,
            'actionUrl' => $this->actionUrl,
            'displayableActionUrl' => str_replace(['mailto:', 'tel:'], '', $this->actionUrl),

            'isSubscriptionEmail' =>true,
            'email' => $this->email,
        ];
    }
}
