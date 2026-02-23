<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    <h1 class="text-center text-8xlt">EasyColoc</h1>
                    <p>An all in one solution to share-house management</p>
                    <small>Join us now!</small>

                    <x-nav-link href="/register">{{ __('Register') }}</x-nav-link>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
