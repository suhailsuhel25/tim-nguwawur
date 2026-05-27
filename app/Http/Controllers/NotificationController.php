<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications for the authenticated user.
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        // Redirect based on related model
        if ($notification->related_model && $notification->related_id) {
            return $this->redirectToRelated($notification);
        }

        return redirect()->back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    /**
     * Redirect logic based on related model.
     */
    private function redirectToRelated(Notification $notification)
    {
        $role = Auth::user()->role;
        $prefix = $role === 'student' ? 'student' : ($role === 'lecturer' ? 'lecturer' : 'admin');

        switch ($notification->related_model) {
            case 'internships':
                return redirect()->route("{$prefix}.internships.show", $notification->related_id);
            case 'weekly_reports':
                return redirect()->route("{$prefix}.weekly_reports.show", $notification->related_id);
            case 'mentorship_sessions':
                return redirect()->route("{$prefix}.mentorship_sessions.show", $notification->related_id);
            case 'final_grades':
                return redirect()->route("{$prefix}.final_grades.show", $notification->related_id);
            default:
                return redirect()->route('notifications.index');
        }
    }
}
