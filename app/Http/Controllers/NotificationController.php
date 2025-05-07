<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_admin', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('customer.notifications.index', compact('notifications'));
    }
    
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
            
        $notification->is_read = true;
        $notification->save();
        
        return redirect()->back()->with('success', 'Notification marked as read');
    }
    
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return redirect()->back()->with('success', 'All notifications marked as read');
    }
    
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }
} 