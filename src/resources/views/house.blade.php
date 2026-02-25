<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
            <div class=" flex justify-between">
                <small class="bg-yellow-600 bg-opacity-30 border-yellow-600 border-2 text-yellow-600 p-2 rounded-md"><i
                        class="fa-solid fa-crown fa-xs" style="color: rgb(255, 212, 59);"></i> Owner:
                    {{ $house->owner[0]->fullname() }}</small>
                <div class="flex gap-2">
                    @if ($house->isOwner())
                        <form action="{{ route('house.destroy', $house) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-red-600 bg-opacity-30 border-red-600 border-2 border-solid p-1 rounded-md text-red-600"
                                type="submit">Delete <i class="fa-regular fa-trash-can fa-xs"
                                    style="color: rgb(231, 24, 24);"></i></button>
                        </form>
                    @endif
                    <form action="{{ route('house.exit', $house) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button
                            class="bg-white bg-opacity-30 border-white border-2 border-solid p-1 rounded-md text-white"
                            type="submit">Exit <i class="fa-solid fa-arrow-right-from-bracket fa-xs"
                                style="color: rgb(255, 255, 255);"></i></button>
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
                    <div class="dark:text-gray-100 w-full">
                        <x-nav-link :href="route('expense.create', $house->id)">{{ __('Create Expense') }}</x-nav-link>
                        <x-nav-link :href="route('category.create', $house->id)">{{ __('Create Category') }}</x-nav-link>
                        <table class="w-full">
                            <tr>
                                <th>Category</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Due</th>
                                <th>Status</th>
                            </tr>
                            <thead>
                            <tbody>
                                @foreach ($expences->user as $expence)
                                    <tr>
*                                       <td>{{$expence->}}</td>
                                    </tr>
                                @endforeach


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
                                    @foreach ($expenses->user as $expense)
                                        <div>
                                            <small></small>
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
                                <h3>Categories</h3>
                                <div>
                                    @foreach ($categories as $category)
                                        <div>
                                            <small>{{ $category->name }}</small>
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
                                        <div class="flex justify-between">
                                            <small>{{ $user->fullname() }}</small>
                                            <div class="flex gap-1">
                                                <form action="">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"><i class="fa-solid fa-crown fa-xs"
                                                            style="color: rgb(255, 212, 59);"></i>
                                                    </button>
                                                </form>
                                                <form action="">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"><i class="fa-solid fa-ban fa-flip-both fa-sm"
                                                            style="color: rgb(255, 59, 59);"></i>
                                                    </button>
                                                </form>


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
