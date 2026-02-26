<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('expence.store', $house->id) }}">
            @csrf
            <!-- expence title -->
            <div class="mt-4">
                <x-input-label for="expence_title" :value="__('Title')" />

                <x-text-input id="expence_title" class="block mt-1 w-full" type="text" name="title" required />

                <x-input-error :messages="$errors->get('expence_title')" class="mt-2" />
            </div>

            <!-- expence amount -->
            <div class="mt-4">
                <x-input-label for="expence_amount" :value="__('Amount')" />

                <x-text-input id="expence_amount" class="block mt-1 w-full" type="number" step="0.01" name="amount"
                    required></x-text-input>

                <x-input-error :messages="$errors->get('expence_amount')" class="mt-2" />
            </div>


            <!-- expence date -->
            <div class="mt-4">
                <x-input-label for="expence_date" :value="__('Date')" />

                <x-text-input id="expence_date" class="block mt-1 w-full" type="date" name="date"
                    required></x-text-input>

                <x-input-error :messages="$errors->get('expence_date')" class="mt-2" />
            </div>


            <!-- expence category -->
            <div class="mt-4">
                <x-input-label for="expence_category" :value="__('Category')" />
                <select name="category_id" id="expence_category"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900
                 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500
                  dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    required>

                    @foreach ($house->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('expence_category_id')" class="mt-2" />
            </div>

            <!-- expence payer -->
            <div class="mt-4">
                <x-input-label for="expence_payer" :value="__('Payer')" />
                <select name="user_id" id="expence_payer"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900
                 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500
                  dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    required>

                    @foreach ($house->user as $user)
                        <option value="{{ $user->id }}">{{ $user->fullname() }}</option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('expence_payer_id')" class="mt-2" />
            </div>




            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-app-layout>
