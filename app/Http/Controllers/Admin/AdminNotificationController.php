<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('is_admin', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.notifications.index', compact('notifications'));
    }
    
    public function markAsRead($id)
    {
        $notification = Notification::where('is_admin', true)
            ->where('id', $id)
            ->firstOrFail();
            
        $notification->is_read = true;
        $notification->save();
        
        return redirect()->back()->with('success', 'Notification marked as read');
    }
    
    public function markAllAsRead()
    {
        Notification::where('is_admin', true)
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return redirect()->back()->with('success', 'All notifications marked as read');
    }
    
    public function getUnreadCount()
    {
        $count = Notification::where('is_admin', true)
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }
} 