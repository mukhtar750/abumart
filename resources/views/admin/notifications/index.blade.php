@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Admin Notifications</h1>
            
            <form action="{{ route('admin.notifications.read-all') }}" method="POST" class="inline mt-4 md:mt-0">
                @csrf
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                    Mark All as Read
                </button>
            </form>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if($notifications->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
                <span class="material-icons text-gray-400 text-6xl mb-4">notifications_off</span>
                <p class="text-gray-600 dark:text-gray-400">No notifications available.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-{{ $notification->color }}-500 hover:shadow-xl transition-shadow duration-200 {{ $notification->is_read ? 'opacity-75' : '' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="material-icons text-{{ $notification->color }}-500">{{ $notification->icon }}</span>
                                <h3 class="font-semibold text-gray-800 dark:text-white">{{ $notification->title }}</h3>
                                @if(!$notification->is_read)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">New</span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                
                                @if(!$notification->is_read)
                                    <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-gray-500">
                                            <span class="material-icons text-sm">check_circle</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $notification->message }}</p>
                        <div class="mt-3">
                            <a href="{{ $notification->link }}" class="text-{{ $notification->color }}-600 hover:text-{{ $notification->color }}-700 text-sm font-medium">
                                View Details →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 