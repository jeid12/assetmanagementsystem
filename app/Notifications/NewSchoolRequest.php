<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Messages\MailMessage;

class NewSchoolRequest extends Notification 
{
    

    /**
     * Create a new notification instance.
     */
    protected $school;
    protected $requestType;
    public function __construct($school, $requestType)
    {
        $this->school = $school;
        $this->requestType = $requestType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Both mail and database
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New School Request: ' . $this->requestType->name)
            ->greeting("Hello {$notifiable->name},")
            ->line("A new {$this->requestType->name} request has been made by the school: {$this->school->name}.")
            
            ->line('Please review the request as soon as possible.');
    }

    /**
     * Get the array representation of the notification for database.
     *
     * @return array<string, mixed>
     */

     public function toDatabase($notifiable)
     {
         return [
             'message' => "New {$this->requestType->name} request from {$this->school->name}",
             'school_id' => $this->school->id,
             'request_type' => $this->requestType->name,
         ];
     }


}