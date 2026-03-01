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
    @if (array_first($errors->get('type')))
        <x-message-success :messages="$errors->get('general')" class="mt-2" />
    @else
        <x-message-error :messages="$errors->get('general')" class="mt-2" />
    @endif
    <div class="py-12 ">
        @if (auth()->user()->notReserved())
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        {{ __('You have no house') }}
                    </div>
                </div>
            </div>
        @else
            @foreach (auth()->user()->house as $house)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col">
                            @if ($house->authIsOwner())
                                <small class="bg-yellow-500 text-black p-2 rounded-md">Owner</small>
                            @endif

                            <a href="house/{{ $house->id }}/details">{{ $house->title }}</a>

                            <small
                                class="bg-gray-500 dark:bg-slate-700 rounded-md p-2">{{ $house->description }}</small>

                        </div>
                    </div>
                </div>
            @endforeach

        @endif


    </div>
</x-app-layout>
