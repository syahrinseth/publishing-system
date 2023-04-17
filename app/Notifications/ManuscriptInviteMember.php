<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Manuscript;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ManuscriptInviteMember extends Notification
{
    use Queueable;

    protected $manuscript;
    protected $user;
    protected $roleName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Manuscript $manuscript, User $user, $roleName)
    {
        $this->manuscript = $manuscript;
        $this->user = $user;
        $this->roleName = $roleName;
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
                    ->greeting("Dear {$this->user->first_name},")
                    ->line("I’d like to invite you as " . strtoupper($this->roleName) ." to review a manuscript {$this->manuscript->manuscript_no} for the Journal of Journal of Smart Sensor and Materials (JSSM).")
                    ->action('View', route('manuscript.edit', ['id' => $this->manuscript->id]))
                    ->line('Kind regards,')
                    ->line('Editor-In-Chief')
                    ->line('Journal of Smart Sensor and Materials (JSSM)');
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
            'message' => "I’d like to invite you as " . strtoupper($this->roleName) ." to review a manuscript {$this->manuscript->manuscript_no} for the Journal of Journal of Smart Sensor and Materials (JSSM).",
            'link' => route('manuscript.edit', ['id' => $this->manuscript->id]),
            'model_type' => Manuscript::class,
            'model_id' => $this->manuscript->id
        ];
    }
}
