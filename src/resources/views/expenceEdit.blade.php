<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('expence.update', $expence->id) }}">
            @csrf
            @method('PUT')
            <!-- expense title -->
            <div class="mt-4">
                <x-input-label for="expense_title" :value="__('Title')" />

                <x-text-input id="expense_title" class="block mt-1 w-full" type="text" name="title" required
                    value="{{ $expence->title }}" />

                <x-input-error :messages="$errors->get('expense_title')" class="mt-2" />
            </div>

            <!-- expense amount -->
            <div class="mt-4">
                <x-input-label for="expense_amount" :value="__('Amount')" />

                <x-text-input id="expense_amount" class="block mt-1 w-full" type="number" step="0.01" name="amount"
                    value="{{ $expence->amount }}" required></x-text-input>

                <x-input-error :messages="$errors->get('expense_amount')" class="mt-2" />
            </div>


            <!-- expense date -->
            <div class="mt-4">
                <x-input-label for="expense_date" :value="__('Date')" />

                <x-text-input id="expense_date" class="block mt-1 w-full" type="date" name="date"
                    required></x-text-input>

                <x-input-error :messages="$errors->get('expense_date')" class="mt-2" />
            </div>


            <!-- expense category -->
            <div class="mt-4">
                <x-input-label for="expense_category" :value="__('Category')" />
                <select name="category_id" id="expense_category"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900
                 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500
                  dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    required>
                    <option value="{{ $expence->category->id }}">{{ $expence->category->name }}</option>

                    @foreach ($house->categories as $category)
                        @if ($category->id != $expence->category->id)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('expense_category_id')" class="mt-2" />
            </div>


            <!-- expence payer -->
            <div class="mt-4">
                <x-input-label for="expence_payer" :value="__('Payer')" />
                <select name="user_id" id="expence_payer"
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900
                 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500
                  dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    required>
                    <option value="{{ $expence->user_id }}">{{ $expence->owner->fullname() }}</option>
                    @foreach ($house->user as $user)
                        @if ($user->id != $expence->user_id)
                            <option value="{{ $user->id }}">{{ $user->fullname() }}</option>
                        @endif
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('expence_payer_id')" class="mt-2" />
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Edit') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-app-layout>
