<?php

namespace App\Notifications;

use App\Enum\Http;
use App\Http\Controllers\Api\ApiController;
use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Vonage;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Credentials\Container;
use Vonage\SMS\Message\SMS;

class SmsSendVerificationCode extends Notification
{
    use Queueable;
    private $verifyCode;
    private $user;
    private $client;
    private $basic;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->basic  = new Basic(env('VONAGE_KEY'), env('VONAGE_SECRET'));
        $this->client = new Client( $this->basic );
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['vonage'];
    }

    /**
     * Get the mail representation of the notification.
     * @return \
     * @param  mixed  $notifiable
     */
    public function toVonage($notifiable)
    {
        $response = $this->client->sms()->send(
            new SMS("90" . $this->user->phoneNumber, 'text', 'Hello verify code is -> ' . rand(1000, 9999), type: 'unicode'));

        return $response->current();
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
