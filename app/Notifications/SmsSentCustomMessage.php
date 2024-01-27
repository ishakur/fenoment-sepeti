<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class SmsSentCustomMessage extends Notification
{
    use Queueable;
    public $user;
    public $text;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$text)
    {
        $this->user = $user;
        $this->text = $text;
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

  public function toVonage()
    {
        $basic = new Basic("8707227c", "uIwpL38KST22RuE2");
        $client = new Client($basic);
        $response=$client->sms()->send(
            new SMS("90".$this->user->phoneNumber,'text' , $this->text));

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
