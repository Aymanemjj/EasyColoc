<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg justify-center">
        <form method="POST" action="{{ route('category.update',$category->id) }}">
            @csrf
            @method('PUT')
            
            <!-- category title -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('Name')" />

                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$category->name}}" required />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- category title -->
            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />

                <x-text-area id="description" class="block mt-1 w-full" type="text" name="description" required>{{$category->description}}</x-text-area>

                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Edit') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-app-layout>
