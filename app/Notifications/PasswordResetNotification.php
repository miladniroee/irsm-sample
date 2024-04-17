<?php

namespace App\Notifications;


use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetNotification extends Notification
{
    protected string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = url("/reset-password/{$this->token}");

        return (new MailMessage)
            ->subject('اعلان بازیابی رمز عبور')
            ->line('این ایمیل به دلیل درخواست بازیابی رمز عبور برای حساب شما ارسال شده است.')
            ->action('بازیابی رمز عبور', $url)
            ->line('اگر شما درخواست بازیابی رمز عبور نداده‌اید، هیچ اقدامی لازم نیست.');
    }
}
