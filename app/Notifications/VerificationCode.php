<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Leonis\Notifications\EasySms\Channels\EasySmsChannel;
use Leonis\Notifications\EasySms\Messages\EasySmsMessage;

class VerificationCode extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [EasySmsChannel::class];
    }

    public function toEasySms($notifiable)
    {
        // 生成4位随机数，左侧补0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        return (new EasySmsMessage)
            ->setTemplate('SMS_165414207')
            ->setData(['code' => 6379]);
    }
}
