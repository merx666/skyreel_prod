<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Profile;

class FeatureExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $profile;
    protected $daysLeft;

    /**
     * Create a new notification instance.
     */
    public function __construct(Profile $profile, int $daysLeft)
    {
        $this->profile = $profile;
        $this->daysLeft = $daysLeft;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $renewUrl = route('payments.feature-profile');
        
        return (new MailMessage)
            ->subject(__('Twoje wyróżnienie profilu wkrótce wygaśnie'))
            ->greeting(__('Cześć :name!', ['name' => $notifiable->name]))
            ->line(__('Twoje wyróżnienie profilu wygaśnie za :days dni.', ['days' => $this->daysLeft]))
            ->line(__('Wyróżniony profil zwiększa Twoją widoczność i szanse na zdobycie nowych zleceń.'))
            ->action(__('Przedłuż wyróżnienie'), $renewUrl)
            ->line(__('Dziękujemy za korzystanie z naszej platformy!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'profile_id' => $this->profile->id,
            'days_left' => $this->daysLeft,
            'message' => __('Twoje wyróżnienie profilu wygaśnie za :days dni.', ['days' => $this->daysLeft]),
            'action_url' => route('payments.feature-profile'),
        ];
    }
}