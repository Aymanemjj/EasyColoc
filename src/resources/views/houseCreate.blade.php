<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

        <form method="POST" action="{{ route('house.store') }}">
            @csrf

            <!-- House title -->
            <div class="mt-4">
                <x-input-label for="house_title" :value="__('Title')" />

                <x-text-input id="house_title" class="block mt-1 w-full" type="text" name="title" required />

                <x-input-error :messages="$errors->get('house_title')" class="mt-2" />
            </div>

            <!-- House title -->
            <div class="mt-4">
                <x-input-label for="house_description" :value="__('description')" />

                <x-text-area id="house_description" class="block mt-1 w-full" type="text" name="description" required></x-text-area>

                <x-input-error :messages="$errors->get('house_description')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-app-layout>
