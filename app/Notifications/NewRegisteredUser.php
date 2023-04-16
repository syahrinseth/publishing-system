<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewRegisteredUser extends Notification
{
    use Queueable;

    protected $toUser;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $toUser, User $user)
    {
        $this->toUser = $toUser;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting("Dear {$this->toUser->first_name}")
                    ->line("{$this->user->first_name} has registered an account in the Journal of Smart Sensor and Materials (JSSM) System.")
                    ->action('View', route('user.edit', ['id' => $this->user->id]))
                    ->line('Thank you for using our application!');
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

    public function toDatabase($notifiable)
    {
        return [
            'message' => "{$this->user->first_name} has registered an account in the Journal of Smart Sensor and Materials (JSSM) System.",
            'link' => route('user.edit', ['id' => $this->user->id]),
            'model_type' => User::class,
            'model_id' => $this->user->id
        ];
    }
}
