<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
            <div class=" flex justify-between">
                <small class="bg-yellow-500 p-2 rounded-md">Owner: {{ $house->owner[0]->firstname }}
                    {{ $house->owner[0]->lastname }}</small>
                <div class="flex gap-2">
                    <form action="{{ route('house.destroy', $house) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="bg-red-600 bg-opacity-30 border-red-600 border-2 border-solid p-1 rounded-md text-red-600"
                            type="submit">Delete</button>
                    </form>
                    <form action="{{ route('house.exit', $house) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button
                            class="bg-white bg-opacity-30 border-white border-2 border-solid p-1 rounded-md text-white"
                            type="submit">Exit</button>
                    </form>
                </div>
            </div>
            {{-- House Details --}}
            <div class=" grid grid-cols-8 gap-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg col-span-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col">
                        <h2>{{ $house->title }}</h2>
                        <small class="bg-gray-500 dark:bg-slate-700 rounded-md p-2">{{ $house->description }}</small>
                    </div>
                    <div>
                        <table>
                            <tr>
                                <th>Category</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Due</th>
                                <th>Status</th>
                            </tr>
                            <thead>
                            <tbody>
                                
                            </tbody>

                        </table>
                    </div>
                </div>
                {{-- House Members --}}
                <div class="col-span-2 flex flex-col gap-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col">
                            <div>
                                <h3>Expenses</h3>
                                <div>
                                    @foreach ($house->user as $user)
                                        <div>
                                            <small>{{ $user->fullname() }}</small>
                                            <div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col">
                            <div>
                                <h3>Members</h3>
                                <div>
                                    @foreach ($house->user as $user)
                                        <div>
                                            <small>{{ $user->fullname() }}</small>
                                            <div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



        </div>
</x-app-layout>
