<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Panel') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats Row --}}
            <div class="flex justify-between md:grid-cols-4 gap-4">
                <div
                    class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex flex-col gap-1 border-r-3 border-green-600 w-full">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Users</span>
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex flex-col gap-1 w-full">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Houses</span>
                    <span
                        class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\House::count() }}</span>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex flex-col gap-1 w-full">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Expenses</span>
                    <span
                        class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Expences::count() }}</span>
                </div>
                {{--                 <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex flex-col gap-1">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Pending Payments</span>
                    <span class="text-3xl font-bold text-red-500">{{}}</span>
                </div>
 --}}
            </div>

            {{-- Users Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Users</h3>
                    <input type="text" placeholder="Search users..."
                        class="text-sm rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-center text-white">
                        <tr class="border-b">
                            <th class="border-x">FullName</th>
                            <th class="border-x">Email</th>
                            <th class="border-x">Reputation</th>
                            <th class="border-x">Role</th>
                            <th class="border-x">Actions</th>
                        </tr>
                        <thead></thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border-r px-2 text-left">{{ $user->fullname() }}</td>
                                    <td class="border-r px-2">{{ $user->email }}</td>
                                    <td class="border-r px-2">{{ $user->reputation }}</td>
                                    <td class="border-r px-2">
                                        <div
                                            class="bg-white bg-opacity-30 text-white border-2 border-white rounded-md px-1 size-fit mx-auto">
                                            <small>{{ $user->role->name }}</small>
                                        </div>
                                    </td>
                                    <td class="border-l text-right px-2">
                                        <form action="{{ route('admin.ban', $user->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            @if ($user->status)
                                                <button
                                                    class="text-red-600 hover:underline text-xs font-bold bg-red-600 bg-opacity-30 border-2 border-red-600 px-2 rounded-md">
                                                    Ban
                                                </button>
                                            @else
                                                <button
                                                    class="text-yellow-600 hover:underline text-xs font-bold bg-yellow-600 bg-opacity-30 border-2 border-yellow-600 px-2 rounded-md">
                                                    UnBan
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            {{-- Houses Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Houses</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-center text-white">
                        <tr class="border-b">
                            <th class="border-x">Title</th>
                            <th class="border-x">Owner</th>
                            <th class="border-x">Members</th>
                            <th class="border-x">Status</th>
                        </tr>
                        <thead></thead>
                        <tbody>
                            @foreach ($houses as $house)
                                <tr>
                                    <td class="border-r px-2">{{ $house->title }}</td>
                                    <td class="border-r px-2">{{ $house->owner[0]->fullname() }}</td>
                                    <td class="border-r px-2">{{ $house->user->count() }}</td>
                                    <td class="border-r px-2">
                                        <div
                                            class="bg-white bg-opacity-30 text-white border-2 border-white rounded-md px-1 size-fit mx-auto">
                                            <small>
                                                @if ($house->status)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4">
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
