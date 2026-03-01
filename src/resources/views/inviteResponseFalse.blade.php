<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <div class="flex flex-col text-center bg-cyan-200 text-cyan-950 p-2 rounded-md">
            <h2 class="font-bold">You aren't the intended recepient</h2>
            <div class="bg-cyan-200, text-cyan-950, p-2, rounded-sm">
                <p>Please register using the email that recieved this invite</p>
            </div>
        </div>
    </div>

</x-app-layout>
