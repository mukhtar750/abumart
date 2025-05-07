@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center bg-gray-100 dark:bg-gray-900 p-6">
    <div class="w-full max-w-5xl bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-6 text-center">User Management</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add New User Button -->
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                + Add New User
            </a>

            <!-- Search Input -->
            <input type="text" id="search" placeholder="Search users..."
                class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-600 dark:text-white"
                onkeyup="searchTable()">
        </div>

        <!-- User Table -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    @foreach($users as $user)
                    <tr class="border-b dark:border-gray-700">
                        <td class="px-4 py-3 text-gray-800 dark:text-white">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                        <td class="px-4 py-3 flex space-x-2">
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg">
                                Edit
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript for Search & Delete Confirmation -->
<script>
    function searchTable() {
        let input = document.getElementById("search").value.toLowerCase();
        let rows = document.querySelectorAll("#userTable tr");
        
        rows.forEach(row => {
            let name = row.cells[0].textContent.toLowerCase();
            let email = row.cells[1].textContent.toLowerCase();
            row.style.display = (name.includes(input) || email.includes(input)) ? "" : "none";
        });
    }

    function confirmDelete(event) {
        if (!confirm("Are you sure you want to delete this user?")) {
            event.preventDefault();
        }
    }
</script>
@endsection
