<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('invite.store', $house->id) }}">
            @csrf

            <!-- invite email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- invite title -->
            <div class="mt-4">
                <x-input-label for="title" :value="__('Title')" />

                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required />

                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- invite body -->
            <div class="mt-4">
                <x-input-label for="body" :value="__('Body')" />

                <x-text-area id="body" class="block mt-1 w-full" type="text" name="body"
                    required></x-text-area>

                <x-input-error :messages="$errors->get('body')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Invite') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-app-layout>
