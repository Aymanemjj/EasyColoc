<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @if (auth()->user()->reputation >= 0)
                <div class="font-semibold text-lg text-gray-800 dark:text-green-600 leading-tight">
                    <h2>Your reputation: {{ auth()->user()->reputation }}</h2>
                </div>
            @else
                <div class="font-semibold text-lg text-gray-800 dark:text-red-600 leading-tight">
                    <h2>Your reputation: {{ auth()->user()->reputation }}</h2>
                </div>
            @endif
        </div>
    </x-slot>
    @if ($errors->get('type'))
        <x-message-success :messages="$errors->get('general')" class="mt-2" />
    @else
        <x-message-error :messages="$errors->get('general')" class="mt-2" />
    @endif
    <div class="py-12 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
            <div class=" flex justify-between">
                <small class="bg-yellow-600 bg-opacity-30 border-yellow-600 border-2 text-yellow-600 p-2 rounded-md"><i
                        class="fa-solid fa-crown fa-xs" style="color: rgb(255, 212, 59);"></i> Owner:
                    {{ $house->owner[0]->fullname() }}</small>
                <div class="flex gap-2">
                    @if ($house->authIsOwner())
                        <form action="{{ route('house.destroy', $house->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-red-600 bg-opacity-30 border-red-600 border-2 border-solid p-1 rounded-md text-red-600"
                                type="submit">Delete <i class="fa-regular fa-trash-can fa-xs"
                                    style="color: rgb(231, 24, 24);"></i></button>
                        </form>
                    @endif
                    <form action="{{ route('house.exit', $house->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button
                            class="bg-white bg-opacity-30 border-white border-2 border-solid p-1 rounded-md text-white"
                            type="submit" name="exit">Exit <i class="fa-solid fa-arrow-right-from-bracket fa-xs"
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
                    <div class="dark:text-gray-100 w-full p-2">
                        <x-nav-link :href="route('expence.create', $house->id)">{{ __('Create expence') }}</x-nav-link>
                        <x-nav-link :href="route('category.create', $house->id)">{{ __('Create Category') }}</x-nav-link>
                        <table class="w-full text-center">
                            <tr class="border-b">
                                <th class="border-x">Title/Category</th>
                                <th class="border-x">Payer</th>
                                <th class="border-x">Amount</th>
                                @if ($house->authIsOwner())
                                    <th class="border-x">Action</th>
                                @endif
                            </tr>
                            <thead>
                            <tbody>
                                @foreach ($expences as $expence)
                                    <tr>
                                        <td class="border-r px-2">
                                            <div class="flex flex-col gap-1 text-left">
                                                <h6>{{ $expence->title }}</h6>
                                                <div
                                                    class="bg-white bg-opacity-30 text-white border-2 border-white rounded-md px-1 size-fit">
                                                    <small>{{ $expence->category->name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border-r px-2">{{ $expence->owner->fullname() }}</td>
                                        <td class="border-r px-2">{{ $expence->amount }} $</td>
                                        @if ($house->authIsOwner())
                                            <td class="border-l text-right px-2">
                                                <div class="flex gap-2 justify-end">
                                                    <button><a href="{{ route('expence.edit', $expence->id) }}"><i
                                                                class="fa-solid fa-pen-to-square fa-xs"
                                                                style="color: rgb(255, 212, 59);"></i></a></button>
                                                    <form action="{{ route('expence.destroy', $expence->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"><i class="fa-regular fa-trash-can fa-xs"
                                                                style="color: rgb(231, 24, 24);"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach


                            </tbody>

                        </table>
                    </div>
                </div>
                {{-- User Expences --}}
                <div class="col-span-2 flex flex-col gap-4">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col">
                            <div>
                                <h3>Your Expenses</h3>
                                <div class="flex flex-col gap-2">
                                    @foreach (auth()->user()->needToPay($house->id) as $expence)
                                        @if ($expence->status)
                                            <?php $color = 'green-600';
                                            $status = 'payed'; ?>
                                        @else
                                            <?php $color = 'yellow-600';
                                            $status = 'pending'; ?>
                                        @endif
                                        <div class="bg-gray-900 rounded-md p-2 border-r-4 border-{{ $color }}">
                                            <h4>{{ $expence->owner->fullname() }}</h4>
                                            <div class="flex justify-between">
                                                <small>{{ $expence->amount }} $</small>
                                                <form action="{{ route('expence.pay', $expence->id) }}" method="post">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit"
                                                        class="bg-{{ $color }} bg-opacity-30 border-2 border-{{ $color }} px-1 rounded-md text-xs">{{ $status }}</button>
                                                </form>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- Categories --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col">
                            <div>
                                <h3>Categories</h3>
                                <div>
                                    @foreach ($categories as $category)
                                        <div class="flex justify-between">
                                            <small>{{ $category->name }}</small>
                                            @if ($house->authIsOwner())
                                                <div class="flex gap-2 justify-end">
                                                    <button><a href="{{ route('category.edit', $category->id) }}"><i
                                                                class="fa-solid fa-pen-to-square fa-xs"
                                                                style="color: rgb(255, 212, 59);"></i></a></button>
                                                    <form action="{{ route('category.destroy', $category->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"><i class="fa-regular fa-trash-can fa-xs"
                                                                style="color: rgb(231, 24, 24);"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- Members --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg ">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col">
                            <div>
                                <h3>Members</h3>
                                <div>
                                    @foreach ($house->user as $user)
                                        <div class="flex justify-between align-bottom">
                                            <small>{{ $user->fullname() }}</small>
                                            <div class="flex gap-1">
                                                @if ($house->userIsOwner($user))
                                                    <i class="fa-solid fa-crown fa-xs"
                                                        style="color: rgb(255, 212, 59);"></i>
                                                @elseif($house->authIsOwner())
                                                    <form
                                                        action="{{ route('user.action', ['id' => $house->id, 'user' => $user->id, 'promote']) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" name="promote"><i
                                                                class="fa-solid fa-crown fa-xs"
                                                                style="color: rgb(255, 212, 59);"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('user.action', ['id' => $house->id, 'user' => $user->id, 'kick']) }}"
                                                        method='post'>
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"><i
                                                                class="fa-solid fa-ban fa-flip-both fa-sm"
                                                                style="color: rgb(255, 59, 59);"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <i class="fa-solid fa-arrow-left fa-xs"
                                                        style="color: rgb(99, 230, 127);"></i>
                                                @endif


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
