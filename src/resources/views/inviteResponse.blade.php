<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="flex justify-center">

        @if (!$invitation->is_active())
            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex flex-col justify-center">
                    <h2 class="font-bold">Inactive Invite</h2>
                    <div class="bg-cyan-200, text-cyan-950, p-2, rounded-sm">
                        <p>This invite is inactive, which means it was used before, ask your sender, to send a new one
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                <div class="flex flex-col justify-center">
                    <h2 class="text-lg text-center text-white font-bold">You have ben Invited</h2>

                    <div class="flex gap-4 justify-center">
                        <form method="POST"
                            action="{{ route('invite.response', ['token' => $invitation->token, 'action' => 1]) }}">
                            @csrf
                            @method('PATCH')

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ms-4">
                                    {{ __('Accept') }}
                                </x-primary-button>
                            </div>
                        </form>

                        <form method="POST"
                            action="{{ route('invite.response', ['token' => $invitation->token, 'action' => 0]) }}">
                            @csrf
                            @method('PATCH')

                            <div class="flex items-center justify-end mt-4">
                                <x-secondary-button-form class="ms-4">
                                    {{ __('Refuse') }}
                                </x-secondary-button-form>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        @endif
    </div>
</x-app-layout>
