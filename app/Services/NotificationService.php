<?php

// app/Services/NotificationService.php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Send an in-app notification to a user.
     *
     * @param int $userId
     * @param string $title
     * @param string $message
     * @param string|null $url
     * @return \App\Models\Notification
     */
    public static function send(int $userId, string $title, string $message, string $url = null)
    {
        return Notification::create([
            'user_id'   => $userId,
            'title'     => $title,
            'message'   => $message,
            'url'       => $url,
            'is_read'   => false,
        ]);
    }
}
