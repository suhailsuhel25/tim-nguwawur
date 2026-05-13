<?php

// app/Services/NotificationService.php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Send an in-app notification to a user.
     *
     * @param int    $userId
     * @param string $title
     * @param string $message
     * @param string $type            info|warning|deadline|status_update
     * @param string|null $relatedModel  e.g. 'internships', 'weekly_reports'
     * @param int|null    $relatedId
     * @return \App\Models\Notification
     */
    public static function send(
        int $userId,
        string $title,
        string $message,
        string $type = 'info',
        ?string $relatedModel = null,
        ?int $relatedId = null
    ): Notification {
        return Notification::create([
            'user_id'       => $userId,
            'title'         => $title,
            'message'       => $message,
            'type'          => $type,
            'is_read'       => false,
            'related_model' => $relatedModel,
            'related_id'    => $relatedId,
        ]);
    }
}
